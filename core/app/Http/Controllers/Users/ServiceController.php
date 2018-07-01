<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User as User;
use App\ServiceImage as ServiceImage;
use App\Tag as Tag;
use App\Order as Order;
use App\Category as Category;
use App\Gateway as Gateway;
use App\Service as Service;
use App\Support as Support;
use App\Social as Social;
use App\GeneralSettings as GS;
use App\Ad;
use Validator;
use Image;
use Auth;

class ServiceController extends Controller
{
    public function index() {
        $data['featuredGigs'] = Service::where('feature', 1)->get();
        $data['categories'] = Category::where('deleted', 0)->get();
        $user = User::find(Auth::user()->id);
        $services = Service::where('user_id', Auth::user()->id)->where('show', 1)->latest()->paginate(10);
        $data['user'] = $user;
        $data['services'] = $services;
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

      return view('users.services.index', $data);
    }

    public function create() {
        $data['gateways'] = Gateway::all();
        $data['user'] = User::find(Auth::user()->id);
        $data['featuredGigs'] = Service::where('feature', 1)->get();
        $data['categories'] = Category::where('deleted', 0)->get();
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

      return view('users.services.create', $data);
    }

    public function store(Request $request) {
      $files = $request->file('images');
      // return $images;
      // taking JSON 'tagsArr' and converting into PHP 'tagsArr' arrays...
      $tagsArr = json_decode($request->tags);

      $fileExtErr = 'no_error';
      $fileCountErr = 'no_error';
      $allowedExts = array('jpg', 'png', 'jpeg');
      $descriptionErr = 'available';
      $introToBuyerErr = 'available';
      $tagsErr = 'filled';

      $rules = [
        'serviceTitle' => 'required',
        'price' => 'required|numeric',
        'category' => 'required',
        'maxDaysToComplete' => 'required|numeric',
        'images' => 'required',
        'description' => 'required',
        'introToBuyer' => 'required'
      ];

      if(empty($tagsArr)) {
        $tagsErr = 'blank';
      }

      // if validation fails for file extension then set $fileExtErr
      // to true...
      if(!empty($files)) {
          foreach($files as $file) {
              $ext = $file->getClientOriginalExtension();
              if(!in_array($ext, $allowedExts)) {
                  $fileExtErr = 'error';
                  break;
              }
          }
          if(count($files) > 3) {
            $fileCountErr = 'error';
          }
      }

      $validator = Validator::make($request->all(), $rules);
      // Validation fails condition...
      if($validator->fails() || $tagsErr == 'blank' || $fileExtErr == 'error' || $fileCountErr=='error') {
        // adding an extra field 'error'...
        $validator->errors()->add('error', 'true');

        if($tagsErr == 'blank') {
          $validator->errors()->add('tags', 'Tags field required');
        }
        if($fileExtErr == 'error') {
            $validator->errors()->add('files', 'uploaded files must be jpg/jpeg/png files');
        }
        if($fileCountErr == 'error') {
            $validator->errors()->add('fileCount', 'Maximum 3 images can be uploaded!');
        }
        return response()->json($validator->errors());
      }

      $service = new Service;
      $service->service_title = $request->serviceTitle;
      $service->price = $request->price;
      $service->category_id = $request->category;
      $service->max_days = $request->maxDaysToComplete;
      $service->description = $request->description;
      $service->intro_to_buyer = $request->introToBuyer;
      $service->user_id = Auth::user()->id;
      $service->save();

      for ($i=0; $i < count($tagsArr) ; $i++) {
        $tag = new Tag;
        $tag->service_id = $service->id;
        $tag->name = $tagsArr[$i];
        $tag->save();
      }

      // storing images under that service...
      foreach($files as $file) {
          $image = $file;
          $filename = uniqid() . '.jpg';
          $location = './assets/users/service_images/' . $filename;
          $background = Image::canvas(760, 400);
          $resizedImage = Image::make($image)->resize(760, 400, function ($c) {
              $c->aspectRatio();
              $c->upsize();
          });
          // insert resized image centered into background
          $background->insert($resizedImage, 'center');
          // save or do whatever you like
          $background->save($location);
          $serviceImage = new ServiceImage;
          $serviceImage->service_id = $service->id;
          $serviceImage->image_name = $filename;
          $serviceImage->save();
      }

      return 'success';
      // $tagsArr = json_decode($request->tags);
      // return $tagsArr[0];
    }

    public function show($id, $userId) {
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
      $service = Service::find($id);
      $data['service'] = $service;
      $user = User::find($userId);
      $data['user'] = $user;
      $category = Category::find($service->category_id);
      $data['category'] = $category;
      $data['featuredGigs'] = Service::where('feature', 1)->get();
      $data['categories'] = Category::where('deleted', 0)->get();
      $data['gateways'] = Gateway::all();
      $data['supports'] = Support::all();
      $data['gs'] = GS::first();
      $data['socials'] = Social::all();
      $data['longAd'] = Ad::where('size', 3)->where('type', 1)->inRandomOrder()->get();
      $data['smallAd'] = Ad::where('size', 1)->where('type', 1)->inRandomOrder()->get();

      return view('users.services.show', $data);
    }

    public function edit($serviceID) {
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
      $data['categories'] = Category::where('deleted', 0)->get();
      $data['service'] = Service::find($serviceID);
      $data['gateways'] = Gateway::all();
      $data['supports'] = Support::all();
      $data['gs'] = GS::first();
      $data['featuredGigs'] = Service::where('feature', 1)->get();
      $data['socials'] = Social::all();
      $data['longAd'] = Ad::where('size', 3)->where('type', 1)->inRandomOrder()->get();
      $data['smallAd'] = Ad::where('size', 1)->where('type', 1)->inRandomOrder()->get();
      $data['user'] = User::find(Auth::user()->id);

      return view('users.services.edit', $data);
    }

    public function update(Request $request) {
      $preServiceImages = ServiceImage::where('service_id', $request->serviceID)->get();
      $files = $request->file('images');
      // return $images;
      // taking JSON 'tagsArr' and converting into PHP 'tagsArr' arrays...
      $tagsArr = json_decode($request->tags);

      $fileExtErr = 'no_error';
      $fileCountErr = 'no_error';
      $allowedExts = array('jpg', 'png', 'jpeg');
      // $descriptionErr = 'available';
      // $introToBuyerErr = 'available';
      $tagsErr = 'filled';

      $rules = [
        'serviceTitle' => 'required',
        'price' => 'required|numeric',
        'category' => 'required',
        'maxDaysToComplete' => 'required|numeric',
        // 'images' => 'required',
        'description' => 'required',
        'introToBuyer' => 'required'
      ];

      // if($request->description == '<h2 style="margin-bottom: 10px; padding: 0px; font-weight: 400; line-height: 24px; font-family: DauphinPlain; font-size: 24px; color: rgb(0, 0, 0);"><br></h2>') {
      //   $descriptionErr = 'not_available';
      // }
      // if($request->introToBuyer == '<h2 style="margin-bottom: 10px; padding: 0px; font-weight: 400; line-height: 24px; font-family: DauphinPlain; font-size: 24px; color: rgb(0, 0, 0);"><br></h2>') {
      //   $introToBuyerErr = 'not_available';
      // }
      if(empty($tagsArr)) {
        $tagsErr = 'blank';
      }

      // if validation fails for file extension then set $fileExtErr
      // to true...
      if(!empty($files)) {
          foreach($files as $file) {
              $ext = $file->getClientOriginalExtension();
              if(!in_array($ext, $allowedExts)) {
                  $fileExtErr = 'error';
                  break;
              }
          }
          if((count($files)+count($preServiceImages)) > 3) {
            $fileCountErr = 'error';
          }
      }

      $validator = Validator::make($request->all(), $rules);
      // Validation fails condition...
      if($validator->fails() || $tagsErr == 'blank' || $fileExtErr == 'error' || $fileCountErr=='error') {
        // adding an extra field 'error'...
        $validator->errors()->add('error', 'true');

        // if($descriptionErr == 'not_available') {
        //   $validator->errors()->add('description', 'Description field required');
        // }
        // if($introToBuyerErr == 'not_available') {
        //   $validator->errors()->add('introToBuyer', 'Introductions to buyer field required');
        // }
        if($tagsErr == 'blank') {
          $validator->errors()->add('tags', 'Tags field required');
        }
        if($fileExtErr == 'error') {
            $validator->errors()->add('files', 'uploaded files must be jpg/jpeg/png files');
        }
        if($fileCountErr == 'error') {
            $validator->errors()->add('fileCount', 'Maximum 3 images can be uploaded!');
        }
        return response()->json($validator->errors());
      }

      $service = Service::find($request->serviceID);
      $service->service_title = $request->serviceTitle;
      $service->price = $request->price;
      $service->category_id = $request->category;
      $service->max_days = $request->maxDaysToComplete;
      $service->description = $request->description;
      $service->intro_to_buyer = $request->introToBuyer;
      $service->user_id = Auth::user()->id;
      $service->save();

      $serviceTagsDelete = Tag::where('service_id', $request->serviceID)->delete();

      for ($i=0; $i < count($tagsArr) ; $i++) {
        $tag = new Tag;
        $tag->service_id = $request->serviceID;
        $tag->name = $tagsArr[$i];
        $tag->save();
      }

      if (!empty($files)) {
        foreach($files as $file) {
            $image = $file;
            $filename = uniqid() . '.jpg';
            $location = 'assets/users/service_images/' . $filename;
            $background = Image::canvas(760, 400);
            $resizedImage = Image::make($image)->resize(760, 400, function ($c) {
                $c->aspectRatio();
                $c->upsize();
            });
            // insert resized image centered into background
            $background->insert($resizedImage, 'center');
            // save or do whatever you like
            $background->save($location);

            $serviceImage = new ServiceImage;
            $serviceImage->service_id = $request->serviceID;
            $serviceImage->image_name = $filename;
            $serviceImage->save();
        }
      }

      return 'success';
      // $tagsArr = json_decode($request->tags);
      // return $tagsArr[0];
    }

    public function deleteServiceImage(Request $request) {
        $serviceImageID = $request->serviceImageID;
        $serviceImage = ServiceImage::find($serviceImageID);
        // foreach ($serviceImages as $serviceImage) {
        $imagePath = './assets/users/service_images/' . $serviceImage->image_name;
        //   unlink($imagePath);
        // }

        // deleting all the service images...
        $serviceImage->delete();
        return "success";
    }

    public function statusUpdate(Request $request) {
      $serviceIDs = json_decode($request->serviceIDs);
      if(empty($serviceIDs) || $request->serviceStatus == 'Select an option') {
        return "will not update";
      } else {
        foreach ($serviceIDs as $serviceID) {
          $service = Service::find($serviceID);
          $service->status = $request->serviceStatus == 'active' ? 1 : 0;
          $service->save();
        }
        return "success";
      }
    }
  }
