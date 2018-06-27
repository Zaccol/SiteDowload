<?php

namespace App\Http\Controllers;
use App\GeneralSettings as GS;
use Illuminate\Http\Request;
use Session;
use Validator;

class EmailSettingController extends Controller
{

    public function __construct() {
      $gs = GS::first();
      $this->sitename = $gs->website_title;
    }

    public function index() {
      $gs = GS::select('email_sent_from', 'email_template')->first();
      $data['sitename'] = $this->sitename;
      $data['page_title'] = 'Email Setting';
      return view('admin.EmailSetting', ['data' => $data, 'gs' => $gs]);
    }

    public function updateEmailSetting(Request $request) {
      $validator = Validator::make($request->all(), [
        'emailSentFrom' => 'required',
        'emailTemplate' => 'required'
      ]);

      if ($validator->fails()) {
          return redirect()->route('admin.EmailSetting')
                      ->withErrors($validator);
                      // ->withInput();
      }

      $gs = GS::first();
      $gs->email_sent_from = $request->emailSentFrom;
      $gs->email_template = $request->emailTemplate;
      $gs->save();

      Session::flash('success', 'Successfully Updated!');

      return redirect()->route('admin.EmailSetting');
    }

  }
