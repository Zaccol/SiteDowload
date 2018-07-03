<?php

namespace App\Http\Controllers\InterfaceControl;

use Illuminate\Http\Request;
use App\GeneralSettings as GS;
use App\Http\Controllers\Controller;
use App\Ad as Ad;
use Session;
use Image;

class AdController extends Controller
{

    public function __construct() {
      $gs = GS::first();
      $this->sitename = $gs->website_title;
    }

    public function index() {
      $data['sitename'] = $this->sitename;
      $data['page_title'] = 'Email Setting';
      $ads = Ad::latest()->get();
      return view('admin.interfaceControl.Ad.index', ['data' => $data, 'ads' => $ads]);
    }

    public function create() {
        $data['sitename'] = $this->sitename;
        $data['page_title'] = 'Email Setting';
        return view('admin.interfaceControl.Ad.add', ['data' => $data]);
    }

    public function store(Request $request) {
      if ($request->type == 1) {
          $request->validate([
              'size' => 'required',
              'redirect_url' => 'required',
              'banner' => 'required|mimes:jpeg,jpg,png',
              'type' => 'required'
          ]);
      } else {
          $request->validate([
              'size' => 'required',
              'script' => 'required',
              'type' => 'required'
          ]);
      }

      if($request->size == 1) {
          $width = 300;
          $height = 250;
      }
      if($request->size == 2) {
          $width = 728;
          $height = 90;
      }
      if($request->size == 3) {
          $width = 300;
          $height = 600;
      }
      $ad = new Ad;
      $ad->type = $request->type;
      if ($request->type == 1) {
          $image = $request->file('banner');
          $fileName = time() . '.jpg';
          $location = './assets/users/ad_images/' . $fileName;
          Image::make($image)->resize($width, $height)->save($location);

          $ad->image = $fileName;
          $ad->url = $request->redirect_url;// code...
      } else {
          $ad->script = $request->script;
      }
      $ad->size = $request->size;
      $ad->save();
      Session::flash('success', 'Banner added successfully!');
      return redirect()->back();
    }

    public function showImage() {
      $adID = $_GET['adID'];
      $ad = Ad::find($adID);
      return $ad;
    }

    public function delete(Request $request) {
      $ad = Ad::find($request->adID);
      $ad->delete();
      Session::flash('success', 'Ad has been deleted!');
      return redirect()->back();
    }

    public function increaseAdView(Request $request) {
        $ad = Ad::find($request->adID);
        $ad->views = $ad->views + 1;
        $ad->save();
    }
}
