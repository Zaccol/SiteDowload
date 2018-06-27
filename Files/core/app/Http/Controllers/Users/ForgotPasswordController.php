<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\User as User;
use DB;
use Auth;
use App\Gateway as Gateway;
use App\Social as Social;
use App\Support as Support;
use App\GeneralSettings as GS;
use App\PasswordReset as PS;

class ForgotPasswordController extends Controller
{
    public function showEmailForm() {
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

        return view('users.verification.emailVerification');
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

        return view('users.verification.smsVerification');
      }

      $data['socials'] = Social::all();
      $data['supports'] = Support::all();
      $data['gs'] = GS::first();
      $data['gateways'] = Gateway::all();
      return view('users.ForgotPassword.showEmailForm', $data);
    }

    public function sendResetPassMail(Request $request)
    {
           $gs = GS::first();

           $this->validate($request,[
                   'resetEmail' => 'required',
               ]);
           $user = User::where('email', $request->resetEmail)->first();
           if ($user == null)
           {
               return back()->with('alert', 'Email Not Available');
           }
           else
           {
               $to =$user->email;
               $name = $user->firstname;
               $subject = 'Password Reset';
               $code = str_random(30);
               $message = 'Use This Link to Reset Password: '.url('/').'/reset/'.$code;

               DB::table('password_resets')->insert(
                   ['email' => $to, 'token' => $code, 'status' => 0, 'created_at' => date("Y-m-d h:i:s")]
               );

               send_email($to, $subject, $name, $message);

               return back()->with('message', 'Password Reset Email Sent Succesfully');

           }

       }

       public function resetPasswordForm($code) {
           $ps = PS::where('token', $code)->first();

           if ($ps == null) {
               return redirect()->route('users.showEmailForm');
           } else {
               if ($ps->status == 0) {
                   $user = User::where('email', $ps->email)->first();
                   $data['email'] = $user->email;
                   $data['socials'] = Social::all();
                   $data['supports'] = Support::all();
                   $data['gs'] = GS::first();
                   $data['gateways'] = Gateway::all();
                   $data['code'] = $code;
                   return view('users.ForgotPassword.resetPassForm', $data);
               } else {
                   return redirect()->route('users.showEmailForm');
               }
           }
       }

       public function resetPassword(Request $request) {
           $messages = [
               'password_confirmation.confirmed' => 'Password doesnot match'
           ];

           $validatedData = $request->validate([
               'password' => 'required|confirmed',
           ], $messages);

           $user = User::where('email', $request->email)->first();
           $user->password = bcrypt($request->password);
           $user->save();
           $ps = PS::where('token', $request->code)->first();
           $ps->status = 1;
           $ps->save();

           $credentials = $request->only('email', 'password');
           if (Auth::attempt($credentials)) {
               // Authentication passed...
               return redirect()->route('users.home');
           }
       }
}
