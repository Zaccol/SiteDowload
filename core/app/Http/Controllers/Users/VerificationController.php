<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User as User;
use Auth;
use Validator;
use Session;

class VerificationController extends Controller
{
    public function emailVerification(Request $request) {
      $validatedData = $request->validate([
          'email_ver_code' => 'required',
      ]);
      $user = User::find(Auth::user()->id);
      if($user->email_ver_code == $request->email_ver_code) {
        $user->email_sent = 0;
        $user->email_verified = 1;
        $user->save();
        return redirect()->route('users.home');
      }
      Session::flash('error', "Verification code didn't match!");
      return redirect()->back();
    }

    public function smsVerification(Request $request) {
      $validatedData = $request->validate([
          'sms_ver_code' => 'required',
      ]);
      $user = User::find(Auth::user()->id);
      if($user->sms_ver_code == $request->sms_ver_code) {
        $user->sms_sent = 0;
        $user->sms_verified = 1;
        $user->save();
        return redirect()->route('users.home');
      }
      Session::flash('error', "Verification code didn't match!");
      return redirect()->back();
    }
}
