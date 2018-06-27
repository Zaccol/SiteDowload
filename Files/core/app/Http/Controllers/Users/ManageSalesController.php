<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User as User;
use App\Order as Order;
use App\Service as Service;
use App\Category as Category;
use App\UserOrderMessage as UserOrderMessage;
use App\DeliveryRevision as DeliveryRevision;
use App\DeliveryAcceptance as DeliveryAcceptance;
use App\Support as Support;
use App\Social as Social;
use App\GeneralSettings as GS;
use App\Gateway as Gateway;
use App\Ad;
use Auth;
use Validator;

class ManageSalesController extends Controller
{
    public function index() {
      $comOrders = Order::where('status', 2)->where('seller_id', Auth::user()->id)->latest()->paginate(15);
      $data['comOrders'] = $comOrders;
      $currOrders = Order::where('status', 1)->where('seller_id', Auth::user()->id)->latest()->paginate(15);
      $data['currOrders'] = $currOrders;
      $penOrders = Order::where('status', 0)->where('seller_id', Auth::user()->id)->latest()->paginate(15);
      $data['penOrders'] = $penOrders;
      $rejOrders = Order::where('status', -1)->where('seller_id', Auth::user()->id)->latest()->paginate(15);
      $data['rejOrders'] = $rejOrders;
      $user = User::find(Auth::user()->id);
      $data['user'] = $user;
      $data['featuredGigs'] = Service::where('feature', 1)->get();
      $data['categories'] = Category::where('deleted', 0)->get();
      $data['gateways'] = Gateway::all();
      $data['supports'] = Support::all();
      $data['gs'] = GS::first();
      $data['socials'] = Social::all();
      $data['longAd'] = Ad::where('size', 3)->where('type', 1)->inRandomOrder()->get();
      $data['smallAd'] = Ad::where('size', 1)->where('type', 1)->inRandomOrder()->get();

      if(Auth::check() && Auth::user()->email_verified == 0) {
        // sending verification code in email...
        if (Auth::user()->email_sent == 0) {
          $to = Auth::user()->email;
          $name = Auth::user()->firstname . ' ' . Auth::user()->lastname;
          $subject = "Email verification code";
          $message = "Your verification code is: " . Auth::user()->email_ver_code;
          send_email( $to, $name, $subject, $message);

          // making the 'email_sent' 1 after sending mail...
          $user = User::find(Auth::user()->id);
          $user->email_sent = 1;
          $user->save();
        }

        return view('users.verification.emailVerification', $data);
      }

      if(Auth::check() && Auth::user()->sms_verified == 0) {
        // sending verification code in email...
        if (Auth::user()->sms_sent == 0) {
          $to = Auth::user()->phone;
          $message = "Your verification code is: " . Auth::user()->sms_ver_code;
          send_sms( $to, $message);

          // making the 'email_sent' 1 after sending mail...
          $user = User::find(Auth::user()->id);
          $user->sms_sent = 1;
          $user->save();
        }

        return view('users.verification.smsVerification', $data);
      }

      return view('users.ManageSales.index', $data);
    }

    public function sellerToBuyerMessages($orderID) {
      $buyerName = User::join('orders', 'users.id', '=', 'orders.buyer_id')
                        ->where('orders.id', $orderID)
                        ->select('users.firstname', 'users.lastname')
                        ->get();
      $data['buyerFirstName'] = $buyerName[0]->firstname;
      $data['buyerLastName'] = $buyerName[0]->lastname;
      $sellerStatus = Order::select('seller_status')
                          ->where('id', $orderID)
                          ->get();
      $data['sellerStatus'] = $sellerStatus[0]->seller_status;
      $data['orderID'] = $orderID;
      $orderTaken = Order::select('taken')->where('id', $orderID)->get();
      $data['orderTaken'] = $orderTaken[0]->taken;
      $orderStatus = Order::select('status')->where('id', $orderID)->get();
      $data['orderStatus'] = $orderStatus[0]->status;
      $uoms = UserOrderMessage::where('order_id', $orderID)->get();
      $data['uoms'] = $uoms;
      $user = User::find(Auth::user()->id);
      $data['user'] = $user;
      $data['featuredGigs'] = Service::where('feature', 1)->get();
      $data['categories'] = Category::where('deleted', 0)->get();
      $data['gateways'] = Gateway::all();
      $data['supports'] = Support::all();
      $data['gs'] = GS::first();
      $data['socials'] = Social::all();
      $data['longAd'] = Ad::where('size', 3)->where('type', 1)->inRandomOrder()->get();
      $data['smallAd'] = Ad::where('size', 1)->where('type', 1)->inRandomOrder()->get();

      if(Auth::check() && Auth::user()->email_verified == 0) {
        // sending verification code in email...
        if (Auth::user()->email_sent == 0) {
          $to = Auth::user()->email;
          $name = Auth::user()->firstname . ' ' . Auth::user()->lastname;
          $subject = "Email verification code";
          $message = "Your verification code is: " . Auth::user()->email_ver_code;
          send_email( $to, $name, $subject, $message);

          // making the 'email_sent' 1 after sending mail...
          $user = User::find(Auth::user()->id);
          $user->email_sent = 1;
          $user->save();
        }

        return view('users.verification.emailVerification', $data);
      }

      if(Auth::check() && Auth::user()->sms_verified == 0) {
        // sending verification code in email...
        if (Auth::user()->sms_sent == 0) {
          $to = Auth::user()->phone;
          $message = "Your verification code is: " . Auth::user()->sms_ver_code;
          send_sms( $to, $message);

          // making the 'email_sent' 1 after sending mail...
          $user = User::find(Auth::user()->id);
          $user->sms_sent = 1;
          $user->save();
        }

        return view('users.verification.smsVerification', $data);
      }

      return view('users.ManageSales.SellerToBuyerMessages', $data);
    }

    public function storeSellerMessage(Request $request) {
      $allowedExts = array('jpg', 'png', 'jpeg', 'rar', 'zip', 'txt', 'doc', 'docx', 'pdf');
      $fileExtErr = 'no_error';

      if ($request->hasFile('attachment')) {
          $validator = Validator::make($request->all(), []);
          $file = $request->file('attachment');
          $ext = $file->getClientOriginalExtension();
          if(!in_array($ext, $allowedExts)) {
              $fileExtErr = 'error';
          }
      } else {
          $validator = Validator::make($request->all(), [
              'message' => 'required'
          ]);
      }


      if ($validator->fails() || $fileExtErr == 'error') {
          $validator->errors()->add('error', 'true');
          if($fileExtErr == 'error') {
              $validator->errors()->add('attachmentType', 'uploaded files must be jpg/jpeg/png/rar/zip/txt/doc/docx/pdf files');
          }
          return response()->json($validator->errors());
      }

      $uom = new UserOrderMessage;
      $uom->user_id = Auth::user()->id;
      $uom->order_id = $request->orderID;
      // if message field contains message then store message...
      if($request->has('message')) {
        $uom->user_message = $request->message;
      }
      if($request->hasFile('attachment')) {
        $file = $request->file('attachment');
        $originalFileName = $file->getClientOriginalName();
        $uniqueFileName = time() . '.' . $file->getClientOriginalExtension();
        // $location = './assets/users/buyer_message_files/' . $uniqueFileName;
        $file->move('./assets/users/seller_messages_files/', $uniqueFileName);
        $uom->file_name = $uniqueFileName;
        $uom->original_file_name = $originalFileName;
      }
      if($request->has('delivery')) {
        $uom->message_type = 'delivery';
      }
      $uom->type = 'seller';
      $uom->user_message = $request->message;
      $uom->save();
      if($request->has('delivery')) {
        $deliveryAcceptance = new DeliveryAcceptance;
        $deliveryAcceptance->user_order_message_id = $uom->id;
        $deliveryAcceptance->save();
      }

      return "success";
    }

    public function accpetProject(Request $request) {
      $order = Order::find($request->orderID);
      // making pending to current order...
      $order->status = 1;
      // sending service price in 'orders' table...
      $order->money = $order->service->price;
      // set 'taken' to '1' if order is accepted...
      $order->taken = 1;
      $order->save();

      $user = User::find($order->buyer_id);

      if (empty($user->ref_username)) {
        $user->balance = $user->balance - $order->service->price;
      } else {
        // Calculating commision charge for this gig...
        $gs = GS::select('ref_com')->first();
        $refCom = $gs->ref_com;
        $comCharge = ($order->service->price*$refCom)/100;

        // User balance has been cut according to the service price and commision charge...
        $user->balance = $user->balance - ($order->service->price+$comCharge);
      }
      $user->save();

      $uom  = new UserOrderMessage;
      $uom->user_id = Auth::user()->id;
      $uom->order_id = $request->orderID;
      $uom->user_message = 'accepted this project!';
      $uom->message_type = 'taken';
      $uom->save();

      // storing another row calculating max dayy to complete project...
      $uom  = new UserOrderMessage;
      $uom->user_id = Auth::user()->id;
      $uom->order_id = $request->orderID;
      // getting maximum days to complete for the ordered service...
      $max_days = $order->service->max_days;
      // calculating and saving the expected date to complete the project...
      $uom->user_message = 'Maximum days to complete the project: '.date('d F, Y', strtotime(date("d F, Y"). ' + '.$max_days.' days'));
      $uom->message_type = 'delivery_date';
      $uom->save();

      return "success";
    }

    public function rejectProject(Request $request) {
      $order = Order::find($request->orderID);
      // order is not taken...
      $order->taken = 0;
      // removing from pending order tab...
      $order->status = -1;
      $order->save();

      $uom = new UserOrderMessage;
      $uom->user_id = Auth::user()->id;
      $uom->order_id = $request->orderID;
      $uom->user_message = 'rejected this project!';
      $uom->message_type = 'notTaken';
      $uom->save();
      return "success";
    }

    // if seller is agreed to give a revision then run this function...
    public function revisionAccepted(Request $request) {

      $uom = new UserOrderMessage;
      $uom->user_id = Auth::user()->id;
      $uom->order_id = $request->orderID;
      $uom->user_message = 'ready to give a revision.';
      $uom->message_type = 'revisionAccepted';
      $uom->save();

      $deliveryRevision = DeliveryRevision::where('user_order_message_id', $request->uomID)->get();
      $deliveryRevision[0]->revision_status = 'revisionAccepted';
      $deliveryRevision[0]->save();

      return "success";
    }

    public function revisionRejected(Request $request) {
        // sending orders into 'rejected orders' tab setting the order_status...
        $order = Order::find($request->orderID);
        $order->status = -1;
        $order->save();

        $buyerInfos = User::join('orders', 'users.id', '=', 'orders.buyer_id')
                              ->where('orders.id', $request->orderID)
                              ->select('orders.buyer_id', 'users.id')
                              ->get();
        $orderMoney = Order::select('money')->where('id', $request->orderID)->get();
        $user = User::find($buyerInfos[0]->buyer_id);
        // adding service price with buyer balance (those who dont have reference username) after seller rejcted revision...
        if(empty($user->ref_username)) {
          $user->balance = $user->balance + $orderMoney[0]->money;
        } else {
          // Calculating commision charge...
          $gs = GS::select('ref_com')->first();
          $refCom = $gs->ref_com;
          $comCharge = ($orderMoney[0]->money*$refCom)/100;

          // adding (service price+reference comission charge) with buyer balance (those who have reference username) after seller rejcted revision...
          $user->balance = $user->balance + ($orderMoney[0]->money+$comCharge);
        }

        $user->save();

        // saving message for rejecting revision
        $uom = new UserOrderMessage;
        $uom->user_id = Auth::user()->id;
        $uom->order_id = $request->orderID;
        $uom->user_message = 'rejected revision.';
        $uom->message_type = 'revisionRejected';
        $uom->save();

        $deliveryRevision = DeliveryRevision::where('user_order_message_id', $request->uomID)->get();
        $deliveryRevision[0]->revision_status = 'revisionRejected';
        $deliveryRevision[0]->save();

        return "success";
    }

}
