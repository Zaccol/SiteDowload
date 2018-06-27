<?php

namespace App\Http\Controllers\InterfaceControl;

use Illuminate\Http\Request;
use App\GeneralSettings as GS;
use App\Social as Social;
use App\Http\Controllers\Controller;
use Session;

class SocialController extends Controller
{
  public function __construct() {
    $gs = GS::first();
    $this->sitename = $gs->website_title;
  }

  public function index() {
    $socials = Social::all();
    $data['sitename'] = $this->sitename;
    $data['page_title'] = 'Email Setting';
    return view('admin.interfaceControl.social.index', ['data' => $data, 'socials' => $socials]);
  }

  public function store(Request $request) {
    $messages = [
      'icon.required' => 'Font Awesome code is required!',
      'title.required' => 'URL field is required',
    ];
    $validatedData = $request->validate([
        'icon' => 'required',
        'title' => 'required',
    ], $messages);
    $social = new Social;
    $social->fontawesome_code = $request->icon;
    $social->url = $request->title;
    $social->save();
    Session::flash('success', 'New social link added successfully!');
    return redirect()->back();
  }

  public function delete(Request $request) {
    $social = Social::find($request->socialID);
    $social->delete();
    Session::flash('success', 'Social deleted successfully');
    return redirect()->back();
  }
}
