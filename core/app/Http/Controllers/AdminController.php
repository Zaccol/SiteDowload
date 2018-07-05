<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\GeneralSettings;
use App\User as User;
use App\Deposit as Deposit;

class AdminController extends Controller
{

	public function __construct(){
		$Gset = GeneralSettings::first();
		$this->sitename = $Gset->sitename;
	}

	public function dashboard(){
		$data['sitename'] = $this->sitename;
		$data['page_title'] = 'DashBoard';

		$data['allUsersBalance'] = User::sum('balance');
		$data['deposit'] = Deposit::where('status', 1)->sum('amount');
		return view('admin.dashboard', ['data' => $data]);
	}



	public function logout()    {
		Auth::guard('admin')->logout();
		session()->flash('message', 'Just Logged Out!');
		return redirect('/admin');
	}

}
