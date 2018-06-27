<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User as User;
use App\Service as Service;
use App\Category as Category;
use App\Post as Post;
use App\Order as Order;
use App\Gateway as Gateway;
use App\Support as Support;
use App\Social as Social;
use App\GeneralSettings as GS;
use App\Ad;
use Validator;
use Auth;
use Session;
use Hash;
use Image;

class ProfileController extends Controller
{
    public function profile($id) {
      $user = User::find($id);
      $data['user'] = $user;
      $data['featuredGigs'] = Service::where('feature', 1)->get();
      $data['categories'] = Category::where('deleted', 0)->get();
      $services = Service::where('user_id', $id)->where('show', 1)->latest()->paginate(9);
      $posts = Post::where('posted_on_user_id', $id)->latest()->paginate(5);
      $ratings = User::join('orders', 'users.id', '=', 'orders.buyer_id')
                              ->select('orders.rating', 'users.firstname', 'users.lastname', 'users.pro_pic')
                              ->where('orders.status', 2)
                              ->where('orders.seller_id', $id)
                              ->paginate(10);
      $data['services'] = $services;
      $data['posts'] = $posts;
      $data['ratings'] = $ratings;
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

      return view('users.profile.profile', $data);
    }

    public function editProfile() {
      $data['featuredGigs'] = Service::where('feature', 1)->get();
      $data['categories'] = Category::where('deleted', 0)->get();
      $data['user'] = User::find(Auth::user()->id);
      $data['gateways'] = Gateway::all();
      $data['supports'] = Support::all();
      $data['socials'] = Social::all();
      $data['gs'] = GS::first();
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

      return view('users.EditProfile', $data);
    }

    public function updateProfile(Request $request) {
        $messages = [
            'proPic.mimes' => 'Profile picture must be a file of type: jpg, jpeg, png.'
        ];
        $validator = Validator::make($request->all(), [
          'proPic' => 'mimes:jpg,jpeg,png',
          'firstname' => 'required',
          'lastname' => 'required',
          'country' => 'required'
        ], $messages);
        if ($validator->fails()) {
            return redirect()->route('editProfile')
                        ->withErrors($validator);
        }
        $user = User::find(Auth::user()->id);
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->country = $request->country;
        $user->address = $request->address;
        $user->zip = $request->zip;
        if($request->hasFile('proPic')) {
          if(!empty($user->pro_pic)) {
            $imagePath = './assets/users/propics/' . $user->pro_pic;
            unlink($imagePath);
          }
          $image = $request->file('proPic');
          $fileName = time() . '.jpg';
          $location = './assets/users/propics/' . $fileName;
          Image::make($image)->resize(300, 300)->save($location);
          $user->pro_pic = $fileName;
        }
        $user->save();

        Session::flash('success', 'Profile has been updated successfully!');
        return redirect()->route('editProfile');
    }

    public function editPassword() {
      $data['user'] = User::find(Auth::user()->id);
      $data['featuredGigs'] = Service::where('feature', 1)->get();
      $data['categories'] = Category::where('deleted', 0)->get();
      $data['gateways'] = Gateway::all();
      $data['supports'] = Support::all();
      $data['socials'] = Social::all();
      $data['gs'] = GS::first();
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

      return view('users.ChangePassword', $data);
    }

    public function updatePassword(Request $request) {
        $messages = [
            'password.required' => 'The new password field is required',
            'password.confirmed' => "Password does'nt match"
        ];
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'password' => 'required|confirmed'
        ], $messages);
        // if given old password matches with the password of this authenticated user...
        if(Hash::check($request->old_password, Auth::user()->password)) {
            $oldPassMatch = 'matched';
        } else {
            $oldPassMatch = 'not_matched';
        }
        if ($validator->fails() || $oldPassMatch=='not_matched') {
            if($oldPassMatch == 'not_matched') {
              $validator->errors()->add('oldPassMatch', true);
            }
            return redirect()->route('editPassword')
                        ->withErrors($validator);
        }

        // updating password in database...
        $user = User::find(Auth::user()->id);
        $user->password = bcrypt($request->password);
        $user->save();

        Session::flash('success', 'Password changed successfully!');

        return redirect()->route('editPassword');
    }
}
