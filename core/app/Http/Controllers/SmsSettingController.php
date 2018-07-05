<?php

namespace App\Http\Controllers;
use App\GeneralSettings as GS;
use Illuminate\Http\Request;
use Session;
use Validator;

class SmsSettingController extends Controller
{
    public function __construct() {
        $gs = GS::first();
        $this->sitename = $gs->website_title;
    }

    public function index() {
      $gs = GS::select('sms_api')->first();
      $data['sitename'] = $this->sitename;
      $data['page_title'] = 'SMS Setting';
      return view('admin.SmsSetting', ['data' => $data, 'smsApi' => $gs->sms_api]);
    }

    public function updateSmsSetting(Request $request) {
        $validator = Validator::make($request->all(), [
  				'smsApi' => 'required'
  			]);

  			if ($validator->fails()) {
  					return redirect()->route('admin.SmsSetting')
  											->withErrors($validator);
  											// ->withInput();
  			}
        $gs = GS::first();
        $gs->sms_api = $request->smsApi;
        $gs->save();
        Session::flash('success', 'Updated Successfully!');
        return redirect()->route('admin.SmsSetting');
    }
}
