<?php

namespace App\Http\Controllers\withdrawMoney;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\GeneralSettings as GS;
use App\Withdraw as Withdraw;
use App\User as User;
use Validator;

class withdrawLogController extends Controller
{
    public function __construct() {
      $gs = GS::first();
      $this->sitename = $gs->website_title;
    }

    public function withdrawLog() {
  		$data['sitename'] = $this->sitename;
  		$data['page_title'] = 'Email Setting';
      $withdraws = Withdraw::latest()->paginate(15);
      $data['withdraws'] = $withdraws;
    	return view('admin.WithdrawMoney.withdrawLog.withdrawLog', ['data' => $data]);
    }

    public function show($wID) {
      $withdraw = Withdraw::find($wID);
      // $data['withdraw'] = $withdraw;
      $data['sitename'] = $this->sitename;
      $data['page_title'] = 'Email Setting';
      return view('admin.WithdrawMoney.withdrawLog.show', ['data' => $data, 'withdraw' => $withdraw]);
    }

    public function storeMessage(Request $request) {
      $gs = GS::first();

      $rules = [
        'message' => 'required'
      ];

      $validator = Validator::make($request->all(), $rules);

      if ($validator->fails()) {
        $validator->getMessageBag()->add('error', 'true');
        return response()->json($validator->errors());
      }

      $withdraw = Withdraw::find($request->wID);
      $withdraw->status = $request->status;
      $withdraw->message = $request->message;
      $withdraw->save();

      if ($request->status == "refunded") {
          $user = User::find($withdraw->user->id);
          $user->balance = $user->balance + ($withdraw->amount+$withdraw->charge);
          $user->save();
      }

      // if email notification is on then send mail...
      if ($gs->email_notification == 1) {
          $to = $withdraw->user->email;
          $name = $withdraw->user->firstname;

          if ($request->status == "processed") {
              $subject = "Withdraw Request Processed";
              $message = $withdraw->message;
              send_email( $to, $name, $subject, $message);
          }

          if ($request->status == "refunded") {
              $subject = "Withdraw Request Refunded";
              $message = $withdraw->message;
              send_email( $to, $name, $subject, $message);
          }
      }


      return "success";
    }

}
