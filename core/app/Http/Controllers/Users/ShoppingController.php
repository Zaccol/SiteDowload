<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User as User;
use App\Order as Order;
use App\UserOrderMessage as UserOrderMessage;
use App\DeliveryRevision as DeliveryRevision;
use App\DeliveryAcceptance as DeliveryAcceptance;
use App\Category as Category;
use App\Service as Service;
use App\Gateway as Gateway;
use App\Support as Support;
use App\Social as Social;
use App\GeneralSettings as GS;
use App\Ad;
use Auth;
use Validator;

class ShoppingController extends Controller
{
    public function myShopping() {
      $data['featuredGigs'] = Service::where('feature', 1)->get();
      $data['categories'] = Category::where('deleted', 0)->get();
      $comOrders = Order::where('status', 2)->where('buyer_id', Auth::user()->id)->latest()->paginate(15);
      $data['comOrders'] = $comOrders;
      $currOrders = Order::where('status', 1)->where('buyer_id', Auth::user()->id)->latest()->paginate(15);
      $data['currOrders'] = $currOrders;
      $penOrders = Order::where('status', 0)->where('buyer_id', Auth::user()->id)->latest()->paginate(15);
      $data['penOrders'] = $penOrders;
      $rejOrders = Order::where('status', -1)->where('buyer_id', Auth::user()->id)->latest()->paginate(15);
      $data['rejOrders'] = $rejOrders;
      $user = User::find(Auth::user()->id);
      $data['user'] = $user;
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

      return view('users.shopping.myShopping', $data);
    }

    public function buyerToSellerMessages($orderID) {
    $sellerName = User::join('orders', 'users.id', '=', 'orders.seller_id')
                        ->where('orders.id', $orderID)
                        ->select('users.firstname', 'users.lastname')
                        ->get();
    $data['sellerFirstName'] = $sellerName[0]->firstname;
    $data['sellerLastName'] = $sellerName[0]->lastname;
    $data['orderID'] = $orderID;
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

      return view('users.shopping.buyerToSellerMessages', $data);
    }

    public function storeBuyerMessage(Request $request) {
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
                $validator->errors()->add('attachment', 'uploaded files must be jpg/jpeg/png/rar/zip/txt/doc/docx/pdf files');
            }
            return response()->json($validator->errors());
        }

      $uom = new UserOrderMessage;
      // $uom->user_id = Auth::user()->id;
      // $uom->order_id =
      // if($request->has('requirement')) {
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
        $file->move('./assets/users/buyer_message_files/', $uniqueFileName);
        $uom->file_name = $uniqueFileName;
        $uom->original_file_name = $originalFileName;
      }
      $uom->type = 'buyer';
      $uom->user_message = $request->message;
      $uom->save();
      // }
      return "success";
    }

    public function rateProject(Request $request) {
      $orderID = $request->orderID;

      $messages = [
        'likeStatus.numeric' => 'You must give a like/dislike'
      ];

      $validator = Validator::make($request->all(), [
        'likeStatus' => 'numeric',
        'ratingComment' => 'required'
      ], $messages);

      if($validator->fails()) {
        $validator->errors()->add('error', 'true');
        return response()->json($validator->errors());
      }

      $order = Order::find($orderID);
      $order->like = $request->likeStatus;
      $order->rating = $request->ratingComment;
      $order->status = 2;
      $order->save();

      $uom = new UserOrderMessage;
      $uom->user_id = Auth::user()->id;
      $uom->order_id = $orderID;
      $uom->user_message = 'accepted the project!';
      $uom->message_type = 'acceptedDelivery';
      $uom->save();

      // setting acceptance status of buyer for the corresponding user_order_message...
      $deliveryAcceptance = DeliveryAcceptance::where('user_order_message_id', $request->uomID)
                                                ->get();
      $deliveryAcceptance[0]->acceptance_status = 'acceptedDelivery';
      $deliveryAcceptance[0]->save();

      // adding order money to seller balance...
      $orderInfos = Order::select('money', 'seller_id', 'buyer_id')
                            ->where('id', $orderID)
                            ->get();
      $user = User::find($orderInfos[0]->seller_id);
      $user->balance = $user->balance + $orderInfos[0]->money;
      $user->save();

      // getting referred user for the buyer...
      $buyer = User::find($orderInfos[0]->buyer_id);
      $refUser = User::where('username', $buyer->ref_username)->first();

      if (empty($refUser)) {
        return "success";
      }

      // Calculating commision charge...
      $gs = GS::select('ref_com')->first();
      $refCom = $gs->ref_com;
      $comCharge = ($orderInfos[0]->money*$refCom)/100;

      // adding comission to referred user balance...
      $refUser->balance = $refUser->balance + $comCharge;
      $refUser->save();

      return "success";
      // return $request->all();
    }

    public function rejectDelivery(Request $request) {
      $order = Order::find($request->orderID);
      $order->save();

      $uom = new UserOrderMessage;
      $uom->user_id = Auth::user()->id;
      $uom->order_id = $request->orderID;
      $uom->user_message = 'rejected the delivery!';
      $uom->message_type = 'rejectedDelivery';
      $uom->save();

      $deliveryRevision = new DeliveryRevision;
      $deliveryRevision->user_order_message_id = $uom->id;
      // $deliveryRevision->revision_status = 'rejectedRevision';
      $deliveryRevision->save();

      $deliveryAcceptance = DeliveryAcceptance::where('user_order_message_id', $request->uomID)
                                                ->get();
      $deliveryAcceptance[0]->acceptance_status = 'rejectedDelivery';
      $deliveryAcceptance[0]->save();

      return "success";
    }
}
