<?php

namespace App\Http\Controllers\InterfaceControl;

use Illuminate\Http\Request;
use App\GeneralSettings as GS;
use App\Support as Support;
use App\Http\Controllers\Controller;
use Session;

class HelpController extends Controller
{
  public function __construct() {
    $gs = GS::first();
    $this->sitename = $gs->website_title;
  }

  public function index() {
    $supports = Support::all();
    $data['sitename'] = $this->sitename;
    $data['page_title'] = 'Email Setting';
    return view('admin.interfaceControl.support.index', ['data' => $data, 'supports' => $supports]);
  }

  public function store(Request $request) {
    $messages = [
      'icon.required' => 'Font Awesome code is required!',
      'title.required' => 'Title field is required',
    ];
    $validatedData = $request->validate([
        'icon' => 'required',
        'title' => 'required',
    ], $messages);
    $support = new Support;
    $support->fontawesome_code = $request->icon;
    $support->title = $request->title;
    $support->save();
    Session::flash('success', 'New support added successfully!');
    return redirect()->back();
  }

  public function delete(Request $request) {
    $support = Support::find($request->supportID);
    $support->delete();
    Session::flash('success', 'Support deleted successfully');
    return redirect()->back();
  }
}
