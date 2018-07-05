<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin as Admin;
use App\GeneralSettings as GS;
use Session;
use Validator;
use Hash;
use Auth;

class ProfileController extends Controller
{
    public function __construct() {
      $gs = GS::first();
      $this->sitename = $gs->website_title;
    }

    public function editProfile($adminID) {
      $data['sitename'] = $this->sitename;
      $data['page_title'] = 'Email Setting';
      $admin = Admin::find($adminID);
      return view('admin.profile.edit', ['data' => $data, 'admin' => $admin]);
    }

    public function updateProfile(Request $request) {
      $validatedData = $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'phone' => 'required|numeric'
      ]);

      $admin = Admin::find($request->adminID);
      $admin->name = $request->name;
      $admin->email = $request->email;
      $admin->phone = $request->phone;
      $admin->save();

      Session::flash('success', 'Profile updated successfully!');

      return redirect()->back();
    }

    public function editPassword() {
      $data['sitename'] = $this->sitename;
      $data['page_title'] = 'Email Setting';
      return view('admin.profile.editPassword', ['data' => $data]);
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
      if(Hash::check($request->old_password, Auth::guard('admin')->user()->password)) {
          $oldPassMatch = 'matched';
      } else {
          $oldPassMatch = 'not_matched';
      }
      if ($validator->fails() || $oldPassMatch=='not_matched') {
          if($oldPassMatch == 'not_matched') {
            $validator->errors()->add('oldPassMatch', true);
          }
          return redirect()->route('admin.editPassword')
                      ->withErrors($validator);
      }

      // updating password in database...
      $user = Admin::find(Auth::guard('admin')->user()->id);
      $user->password = bcrypt($request->password);
      $user->save();

      Session::flash('success', 'Password changed successfully!');

      return redirect()->back();
    }
}
