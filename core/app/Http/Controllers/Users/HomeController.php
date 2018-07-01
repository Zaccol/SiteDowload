<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service as Service;
use App\User as User;
use App\Slider as Slider;
use App\Category as Category;
use App\Gateway as Gateway;
use App\Support as Support;
use App\Social as Social;
use App\GeneralSettings as GS;
use App\Tag as Tag;
use Auth;

class HomeController extends Controller
{
    public function home() {
        $data['featuredGigs'] = Service::where('feature', 1)->get();
        $data['categories'] = Category::all();
        $data['gateways'] = Gateway::all();
        if (Auth::check()) {
            $services = Service::orderBy('feature', 'DESC')->where('show', 1)->where('status', 1)->where('user_id', '<>', Auth::user()->id)->latest()->paginate(15);
        } else {
            $services = Service::orderBy('feature', 'DESC')->where('show', 1)->where('status', 1)->latest()->paginate(15);
        }
        $data['services'] = $services;
        $data['sliders'] = Slider::all();
        $data['supports'] = Support::all();
        $data['gs'] = GS::first();
        $data['socials'] = Social::all();

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
        $data['user'] = User::find(Auth::user()->id);

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
        $data['user'] = User::find(Auth::user()->id);
        return view('users.verification.smsVerification',$data);
      }

      return view('users.home', $data);
    }

    public function servicesAccoordingToCat($catID) {
        $data['featuredGigs'] = Service::where('feature', 1)->get();
        $data['categories'] = Category::all();
        $data['gateways'] = Gateway::all();
        $services = Service::orderBy('feature', 'DESC')->where('show', 1)->where('status', 1)->where('category_id', $catID)->latest()->paginate(15);
        $data['services'] = $services;
        $data['sliders'] = Slider::all();
        $data['supports'] = Support::all();
        $data['gs'] = GS::first();
        $data['socials'] = Social::all();

        if(Auth::check() && Auth::user()->email_verified == 0) {
          // sending verification code in email...
          if (Auth::user()->email_sent == 0) {
            $to = Auth::user()->email;
            $name = Auth::user()->firstname . ' ' . Auth::user()->lastname;
            $subject = "Email verification code";
            $message = "Your verification code is: " . Auth::user()->email_ver_code;
            // send_email( $to, $name, $subject, $message);

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
            // send_sms( $to, $message);

            // making the 'email_sent' 1 after sending mail...
            $user = User::find(Auth::user()->id);
            $user->sms_sent = 1;
            $user->save();
          }

          return view('users.verification.smsVerification', $data);
        }

        return view('users.home', $data);
    }

    public function searchServices(Request $request) {
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
          $data['user'] = User::find(Auth::user()->id);

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
          $data['user'] = User::find(Auth::user()->id);
          return view('users.verification.smsVerification',$data);
        }

        $data['featuredGigs'] = Service::where('feature', 1)->get();
        $data['categories'] = Category::all();
        $data['gateways'] = Gateway::all();
        $tags = Tag::select('name', 'service_id')->where('name', 'like', '%'.$request->searchTerm.'%')->get();
        $serviceIDsArr = [];
        for ($i=0; $i<count($tags); $i++) {
            $serviceIDsArr[] = $tags[$i]->service_id;
        }
        // return $serviceIDsArr;
        if (Auth::check()) {
            $filteredServices = Service::whereIn('id', $serviceIDsArr)
                                        ->where('services.show', 1)->where('services.status', 1)
                                        ->where('user_id', '<>', Auth::user()->id)
                                        ->orderBy('services.feature', 'DESC')
                                        ->latest()
                                        ->paginate(15);
        } else {
            $filteredServices = Service::whereIn('id', $serviceIDsArr)
                                        ->where('services.show', 1)->where('services.status', 1)
                                        ->orderBy('services.feature', 'DESC')
                                        ->latest()
                                        ->paginate(15);
        }
        // return $filteredServices;
        $data['services'] = $filteredServices;
        $data['sliders'] = Slider::all();
        $data['supports'] = Support::all();
        $data['gs'] = GS::first();
        $data['socials'] = Social::all();

        return view('users.home', $data);
    }
}
