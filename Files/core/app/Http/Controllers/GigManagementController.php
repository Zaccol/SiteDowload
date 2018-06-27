<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service as Service;
use App\GeneralSettings as GS;

class GigManagementController extends Controller
{
  public function __construct() {
    $gs = GS::first();
    $this->sitename = $gs->website_title;
  }

  public function allGigs() {
    $data['sitename'] = $this->sitename;
    $data['page_title'] = 'Email Setting';
    $services = Service::latest()->paginate(10);
    return view('admin.gigManagement.allGigs', ['data' => $data, 'services' => $services]);
  }

  public function gigHide(Request $request) {
      // return $serviceID;
      $serviceID = $request->serviceID;
      $service = Service::find($serviceID);
      $service->show = 0;
      $service->save();
      return "success";
  }

  public function gigShow(Request $request) {
      $serviceID = $request->serviceID;
      $service = Service::find($serviceID);
      $service->show = 1;
      $service->save();
      return "success";
  }

  public function changeFeatureStatus(Request $request) {
      $serviceID = $request->serviceID;
      $featureStatus = $request->featureStatus;
      $service = service::find($serviceID);
      $service->feature = $featureStatus;
      $service->save();
      return "success";
  }

  public function hiddenGigs() {
      $data['sitename'] = $this->sitename;
      $data['page_title'] = 'Email Setting';
      $gs = GS::first();
      $hiddenServices = Service::where('show', 0)->paginate(10);
      return view('admin.gigManagement.hiddenGigs', ['gs' => $gs, 'data' => $data, 'hiddenServices' => $hiddenServices]);
  }

  public function featuredGigs() {
      $data['sitename'] = $this->sitename;
      $data['page_title'] = 'Email Setting';
      $gs = GS::first();
      $featuredServices = Service::where('feature', 1)->paginate(10);
      return view('admin.gigManagement.featuredGigs', ['gs' => $gs, 'data' => $data, 'featuredServices' => $featuredServices]);
  }
}
