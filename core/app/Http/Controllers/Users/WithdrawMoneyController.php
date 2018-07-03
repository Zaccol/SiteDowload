<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\WithdrawMethod as WM;
use App\Withdraw as Withdraw;
use App\Service as Service;
use App\Category as Category;
use App\Gateway as Gateway;
use App\Support as Support;
use App\Social as Social;
use App\GeneralSettings as GS;
use App\User as User;
use Auth;
use Validator;

class WithdrawMoneyController extends Controller
{
    public function withdrawMoney() {
      $data['user'] = User::find(Auth::user()->id);
      $data['featuredGigs'] = Service::where('feature', 1)->get();
      $data['categories'] = Category::where('deleted', 0)->get();
      $wms = WM::where('deleted', 0)->get();
      $data['wms'] = $wms;
      $data['gateways'] = Gateway::all();
      $data['supports'] = Support::all();
      $data['socials'] = Social::all();
      $data['gs'] = GS::first();

      // checking if the email is verified
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

      return view('users.withdrawMoney.withdrawMoney', $data);
    }

    public function store(Request $request) {
      $wm = WM::find($request->wmID);
      // calculating the total charge for this withdraw method and this requested amount...
      $charge = $wm->fixed_charge + (($wm->percentage_charge*$request->amount)/100);

      $rules = [
        'amount' => [
          'required',
          function($attribute, $value, $fail) use ($charge, $wm) {
            // if the amount is greater than maximum limit...
            if ($value > $wm->max_limit) {
              return $fail('Maximum amount limit is '.$wm->max_limit);
            }
            // if user balance is less than (requested amount + charge)...
            if (Auth::user()->balance < ($value + $charge)) {
              return $fail('You dont have enough balance in your account to make this withdraw request!');
            }
            // if the amount is less than minimum limit...
            if ($value < $wm->min_limit) {
              return $fail('Minimum amount limit is '.$wm->min_limit);
            }
          }
        ],
        'details' => 'required'
      ];

      $validator = Validator::make($request->all(), $rules);

      if ($validator->fails()) {
        $validator->getMessageBag()->add('error', 'true');
        return response()->json($validator->errors());
      }

      // if all validation passes then save the withdraw request in the database...
      $withdraw = new Withdraw;
      $withdraw->trx = str_random(12);
      $withdraw->user_id = Auth::user()->id;
      $withdraw->amount = $request->amount;
      $withdraw->withdraw_method_id = $wm->id;
      $withdraw->charge = $charge;
      $withdraw->status = 'pending';
      $withdraw->details = $request->details;
      $withdraw->save();

      // cut user balance..
      $user = User::find(Auth::user()->id);
      $user->balance = $user->balance - ($withdraw->charge + $withdraw->amount);
      $user->save();

      return "success";
    }
}
