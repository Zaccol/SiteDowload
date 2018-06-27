<?php

namespace App\Http\Controllers\InterfaceControl;

use Illuminate\Http\Request;
use App\GeneralSettings as GS;
use App\Http\Controllers\Controller;
use Session;

class ContactController extends Controller
{

    public function __construct() {
      $gs = GS::first();
      $this->sitename = $gs->website_title;
    }

    public function index() {
      $data['sitename'] = $this->sitename;
      $data['page_title'] = 'Email Setting';
      $gs = GS::select('phone', 'email')->first();
      return view('admin.interfaceControl.contact.index', ['data' => $data, 'gs' => $gs]);
    }

    public function update(Request $request) {
      $validatedData = $request->validate([
          'phone' => 'required',
          'email' => 'required',
      ]);

      $gs = GS::first();
      $gs->phone = $request->phone;
      $gs->email = $request->email;
      $gs->save();

      Session::flash('success', 'Contact updated successfully!');
      return redirect()->back();
    }
}
