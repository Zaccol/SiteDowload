<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GeneralSettings;
use Session;
use Auth;
use Validator;

class GeneralSettingController extends Controller
{

	public function __construct(){
		$Gset = GeneralSettings::first();
		$this->sitename = $Gset->website_title;
	}

	public function index(){
		$data['sitename'] = $this->sitename;
		return view('admin.loginform', compact('data'));
	}

	public function GenSetting(){
		$data['sitename'] = $this->sitename;
		$Gset = GeneralSettings::first();
		$data['page_title'] = 'General Setting';
			// $Gset = GeneralSettings::first();
		return view('admin.GeneralSettings', ['data' => $data, 'Gset' => $Gset]);
	}

	public function UpdateGenSetting(Request $request){
			$messages = [
				'secColorCode.required' => 'Secondary color code is required',
				'secColorCode.size' => 'Secondary color code must have 6 characters',
				'baseColorCode.required' => 'Base color code is required',
				'baseColorCode.size' => 'Base color code must have 6 characters',
				// 'decimalAfterPt.required' => 'Decimal after point is required',
			];

			$validator = Validator::make($request->all(), [
				'websiteTitle' => 'required',
				'baseColorCode' => 'required|size:6',
				'secColorCode' => 'required|size:6',
				'reference_commission' => 'required'
				// 'decimalAfterPt' => 'required'
			], $messages);

			if ($validator->fails()) {
					return redirect()->route('admin.GenSetting')
											->withErrors($validator);
											// ->withInput();
			}

			$generalSettings = GeneralSettings::first();

			$generalSettings->website_title = $request->websiteTitle;
			$generalSettings->base_color_code = $request->baseColorCode;
			$generalSettings->sec_color_code = $request->secColorCode;
			$generalSettings->ref_com = $request->reference_commission;
			$generalSettings->registration = $request->registration=='on'?1:0;
			$generalSettings->email_verification = $request->emailVerification=='on'?0:1;
			$generalSettings->sms_verification = $request->smsVerification=='on'?0:1;
			// $generalSettings->decimal_after_pt = $request->decimalAfterPt;
			$generalSettings->email_notification = $request->emailNotification=='on'?1:0;
			$generalSettings->sms_notification = $request->smsNotification=='on'?1:0;

			$generalSettings->save();

			Session::flash('success', 'Successfully Updated!');

			return redirect()->route('admin.GenSetting');
	}



}
