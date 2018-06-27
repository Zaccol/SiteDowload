<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order as Order;
use App\Service as Service;
use App\User as User;
use App\UserOrderMessage as UserOrderMessage;
use Auth;

class OrderController extends Controller
{
    public function placeOrder(Request $request) {
      // return $request->all();
      $service = Service::find($request->serviceID);

      // checking if the user has enough balance to buy this gig...
      if(Auth::user()->balance < $service->price) {
        $errors['balance'] = "You don't have enough balance!";
        return response()->json($errors);
      }

      // creating a new order in 'orders' table...
      $order = new Order;
      $order->buyer_id = Auth::user()->id;
      $order->seller_id = $service->user->id;
      $order->service_id = $request->serviceID;
      // $order->money = $service->price;
      $order->status = 0;
      $order->save();

      // cutting user's balance...
      // $user = User::find(Auth::user()->id);
      // $user->balance = $user->balance - $service->price;
      // $user->save();

      // sending Introduction to Buyer message to buyer...
      $uom = new UserOrderMessage;
      $uom->user_id = $service->user->id;
      $uom->order_id = $order->id;
      $uom->user_message = $service->intro_to_buyer;
      $uom->type = 'seller';
      $uom->message_type = 'introToBuyer';
      $uom->save();
      return $order->id;
    }
}
