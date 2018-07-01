<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use App\GeneralSettings;

class AdminLoginController extends Controller
{


	public function __construct(){
		$Gset = GeneralSettings::first();
		$this->sitename = $Gset->website_title;
	}


	public function index(){

		if(Auth::guard('admin')->check()){
			return redirect()->route('admin.dashboard');
		}

		$data['sitename'] = $this->sitename;
		return view('admin.loginform', compact('data'));
	}

	public function authenticate(Request $request){
		if (Auth::guard('admin')->attempt([
			'username' => $request->username,
			'password' => $request->password,
		])) {
			return "ok";
		}
		return "The Combination of Username and Password is Wrong!";
	}
}
