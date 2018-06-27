<?php

namespace App\Http\Controllers\InterfaceControl;

use Illuminate\Http\Request;
use App\GeneralSettings as GS;
use App\Http\Controllers\Controller;
use Session;

class FooterController extends Controller
{
    public function __construct() {
      $gs = GS::first();
      $this->sitename = $gs->website_title;
    }

    public function index() {
      $footer = GS::select('footer')->first();
      $data['sitename'] = $this->sitename;
      $data['page_title'] = 'Email Setting';
      return view('admin.interfaceControl.footer.index', ['data' => $data, 'footer' => $footer]);
    }

    public function update(Request $request) {
      $footer = GS::first();
      $footer->footer = $request->footer;
      $footer->save();
      Session::flash('success', 'Footer updated successfully!');
      return redirect()->back();
    }
}
