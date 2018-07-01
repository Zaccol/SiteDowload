<?php

namespace App\Http\Controllers\InterfaceControl;

use Illuminate\Http\Request;
use App\GeneralSettings as GS;
use App\Http\Controllers\Controller;
use Session;
use Image;

class LogoIconController extends Controller
{

    public function __construct() {
      $gs = GS::first();
      $this->sitename = $gs->website_title;
    }

    public function index() {
      $data['sitename'] = $this->sitename;
      $data['page_title'] = 'Email Setting';
      return view('admin.interfaceControl.logoIcon.index', ['data' => $data]);
    }

    public function update(Request $request) {

      $gs = GS::find(1);
      if($request->hasFile('logo')) {

        $logoImagePath = './assets/users/interfaceControl/logoIcon/logo.jpg';
        if(file_exists($logoImagePath)) {
          unlink($logoImagePath);
        }
        // $logoImage = $request->file('logo');
        // $logoFileName = 'logo.jpg';
        // $logoLocation = './assets/users/interfaceControl/logoIcon/' . $logoFileName;
        // Image::make($logoImage)->resize(160, 40)->save($logoLocation);
        $request->file('logo')->move('assets/users/interfaceControl/logoIcon/','logo.jpg');
      }
      if($request->hasFile('icon')) {
        $iconImagePath = './assets/users/interfaceControl/logoIcon/icon.jpg';
        if(file_exists($iconImagePath)) {
          unlink($iconImagePath);
        }
        // $iconImage = $request->file('icon');
        // $iconFileName = 'icon.jpg';
        // $iconLocation = './assets/users/interfaceControl/logoIcon/' . $iconFileName;
        // Image::make($iconImage)->resize(40, 40)->save($iconLocation);
        $request->file('icon')->move('assets/users/interfaceControl/logoIcon/','icon.jpg');
      }
      Session::flash('success', 'Logo updated successfully!');
      return redirect()->back();
    }
}
