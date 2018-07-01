<?php

namespace App\Http\Controllers\InterfaceControl;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\GeneralSettings as GS;
use Session;

class fdCommentController extends Controller
{

    public function __construct() {
      $gs = GS::first();
      $this->sitename = $gs->website_title;
    }

    public function index() {
      $data['sitename'] = $this->sitename;
      $data['page_title'] = 'Email Setting';
      $gs = GS::first();
      return view('admin.interfaceControl.fbComment.index', ['data' => $data, 'gs' => $gs]);
    }

    public function update(Request $request) {
      $gs = GS::first();
      $gs->comment_script = $request->comment_script;
      $gs->save();
      Session::flash('success', 'Comment script updated successfully!');
      return redirect()->back();
    }
}
