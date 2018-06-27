<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\GeneralSettings;
use App\Users;

class UserController extends Controller
{
	public function __construct(){
		$Gset = GeneralSettings::first();
		$this->sitename = $Gset->sitename;
	}

	public function allUsers(){
		$data['sitename'] = $this->sitename;
		$data['page_title'] = 'User List';
			$Gset = GeneralSettings::first();
			$users = Users::all();
		return view('admin.user.index', compact('data', 'Gset', 'users'));
	}





	public function SingleUser($id){
 		$user = Users::findOrFail($id);
		$data['sitename'] = $this->sitename;
		$data['page_title'] = 'User Profile';
		
		return view('admin.user.single', compact('data', 'Gset', 'user'));

	}

}
