<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\GeneralSettings;
use App\Macs;

class MacController extends Controller
{
	public function __construct(){
		$Gset = GeneralSettings::first();
		$this->sitename = $Gset->sitename;
	}

	public function allMacs(){
		$data['sitename'] = $this->sitename;
		$data['page_title'] = 'Mac ID Management';
			$Gset = GeneralSettings::first();
			$macs = Macs::all();
		return view('admin.mac.index', compact('data', 'Gset', 'macs'));
	}

	public function UpdateMacs(Request $request){

$macCount = Macs::where('macid', $request->macid)->where('id', '!=', $request->id)->count();
if ($macCount > 0){
return back()->with('alert', 'MAC ID Already Exist');
} 

		if ($request->id==0) {

			$mac['macid'] = $request->macid;
			$res = Macs::create($mac);
			if ($res) {
				return back()->with('success', 'New MAC ID Added Successfully!');
			}else{
				return back()->with('alert', 'Problem With Adding New MAC ID');
			}

		}else{
			$mac = Macs::findOrFail($request->id);
			$mac['macid'] = $request->macid;
			$res = $mac->save();
			if ($res) {
				return back()->with('success', 'MAC ID Updated Successfully!');
			}else{
				return back()->with('alert', 'Problem With Updating MAC ID');
			}

		}




	}

}
