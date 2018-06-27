<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GeneralSettings as GS;
use App\User as User;
use App\Order as Order;
use App\Withdraw as Withdraw;
use App\Deposit as Deposit;
use Session;

class UserManagementController extends Controller
{
    public function __construct() {
      $gs = GS::first();
      $this->sitename = $gs->website_title;
    }

    public function allUsers() {
      $users = User::paginate(15);
      $data['sitename'] = $this->sitename;
      $data['page_title'] = 'Email Setting';
      return view('admin.UserManagement.allUsers',['data' => $data, 'users' => $users]);
    }

    public function bannedUsers() {
      $bannedUsers = User::where('status', 'blocked')->paginate(15);
      $data['sitename'] = $this->sitename;
      $data['page_title'] = 'Email Setting';
      return view('admin.UserManagement.bannedUsers',['data' => $data, 'bannedUsers' => $bannedUsers]);
    }

    public function userDetails($userID) {
      $ordersCount = Order::where('seller_id', $userID)
                        ->orWhere('buyer_id', $userID)
                        ->where('status', 2)
                        ->count();
      $ordersMoney = Order::where('seller_id', $userID)
                        ->orWhere('buyer_id', $userID)
                        ->where('status', 2)
                        ->sum('money');
      $user = User::find($userID);
      $data['sitename'] = $this->sitename;
      $data['page_title'] = 'Email Setting';
      return view('admin.UserManagement.userDetails.userDetails', ['data' => $data, 'user' => $user, 'ordersCount' => $ordersCount, 'ordersMoney' => $ordersMoney]);
    }

    public function verifiedUsers() {
      $verifiedUsers = User::where('email_verified', 1)->where('sms_verified', 1)->paginate(15);
      $data['sitename'] = $this->sitename;
      $data['page_title'] = 'Email Setting';
      return view('admin.UserManagement.verifiedUsers', ['data' => $data, 'verifiedUsers' => $verifiedUsers]);
    }

    public function mobileUnverifiedUsers() {
      $mobileUnverifiedUsers = User::where('sms_verified', 0)->paginate(15);
      $data['sitename'] = $this->sitename;
      $data['page_title'] = 'Email Setting';
      return view('admin.UserManagement.mobileUnverifiedUsers', ['data' => $data, 'mobileUnverifiedUsers' => $mobileUnverifiedUsers]);
    }

    public function emailUnverifiedUsers() {
      $emailUnverifiedUsers = User::where('email_verified', 0)->paginate(15);
      $data['sitename'] = $this->sitename;
      $data['page_title'] = 'Email Setting';
      return view('admin.UserManagement.emailUnverifiedUsers', ['data' => $data, 'emailUnverifiedUsers' => $emailUnverifiedUsers]);
    }

    public function addSubtractBalance($userID) {
      $user = User::select('id', 'username', 'balance')->where('id', $userID)->first();
      $data['sitename'] = $this->sitename;
      $data['page_title'] = 'Email Setting';
      return view('admin.UserManagement.userDetails.addSubtractBalance', ['data' => $data, 'user' => $user]);
    }

    public function emailToUser($userID) {
      $user = User::find($userID);
      $data['sitename'] = $this->sitename;
      $data['page_title'] = 'Email Setting';
      return view('admin.UserManagement.userDetails.emailToUser', ['data' => $data, 'user' => $user]);
    }

    public function updateUserBalance(Request $request) {
      $validatedData = $request->validate([
          'amount' => 'required',
      ]);

      $user = User::find($request->userID);
      $balance = $user->balance;
      // if add money operation is selected then add the amount...
      if ($request->has('operation')) {
        $balance = $balance + $request->amount;
        $successMessage = 'Amount has been added successfully!';
      } else {
        $balance = $balance - $request->amount;
        $successMessage = 'Amount has been subtacted successfully!';
      }
      if($request->has('message')) {
        $name = $user->firstname . ' ' . $user->lastname;
        $subject = 'Balance updated in your account';
        $message = $request->message;
        send_email( $user->email, $name, $subject, $message);
      }

      $user->balance = $balance;
      $user->save();
      Session::flash('success', $successMessage);
      return redirect()->back();
    }

    public function sendEmailToUser(Request $request) {
      $validatedData = $request->validate([
          'subject' => 'required',
          'message' => 'required'
      ]);
      $user = User::find($request->userID);
      $to = $user->email;
      $name = $user->firstname . ' ' .$user->lastname;
      $subject = $request->subject;
      $message = $request->message;
      send_email( $to, $name, $subject, $message);
      Session::flash('success', 'Mail sent successfully!');
      return redirect()->back();
    }

    public function updateUserDetails(Request $request) {
      $validatedData = $request->validate([
        'firstname' => 'required',
        'lastname' => 'required',
        'phone' => 'required',
        'country' => 'required'
      ]);

      $user = User::find($request->userID);
      $user->firstname = $request->firstname;
      $user->lastname = $request->lastname;
      $user->phone = $request->phone;
      // $user->dob = $request->dob;
      $user->country = $request->country;
      $user->status = $request->status=='on'?'active':'blocked';
      $user->email_verified = $request->emailVerification=='on'?1:0;
      if ($request->emailVerification != 'on') {
        if ($user->email_sent == 0) {
          $code = rand(1000, 9999);
          $user->email_ver_code = $code;
          $to = $user->email;
          $name = $user->firstname . ' ' .$user->lastname;
          $subject = "Verification Code";
          $message = "Your verification code is: " . $code;
          send_email( $to, $name, $subject, $message);
          $user->email_sent = 1;
        }
      } else {
        $user->email_sent = 0;
      }
      $user->sms_verified = $request->smsVerification=='on'?1:0;
      if ($request->smsVerification != 'on') {
        if ($user->sms_sent == 0) {
          $code = rand(1000, 9999);
          $user->sms_ver_code = $code;
          $to = $user->phone;
          $message = "Your verification code is: " . $code;
          send_sms( $to, $message);
          $user->sms_sent = 1;
        }
    } else {
        $user->sms_sent = 0;
    }
      $user->save();


      Session::flash('success', 'User details has been updated successfully!');

      return redirect()->back();
      // return $request->all();
    }

    public function withdrawLog($userID) {
      $data['sitename'] = $this->sitename;
      $withdraws = Withdraw::where('user_id', $userID)->paginate(15);
      $data['withdraws'] = $withdraws;
      return view('admin.WithdrawMoney.withdrawLog.withdrawLog', ['data' => $data]);
    }

    public function depositLog($userID) {
        $data['sitename'] = $this->sitename;
        $data['page_title'] = 'Deposit Log';
        $data['deposits'] = Deposit::where('user_id', $userID)->paginate(15);
        return view('admin.DepositMoney.depositLog', ['data' => $data]);
    }
}
