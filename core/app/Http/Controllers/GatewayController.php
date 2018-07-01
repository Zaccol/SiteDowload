<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gateway as Gateway;
use App\GeneralSettings;
use Session;
use Image;

class GatewayController extends Controller
{
    public function __construct(){
      $Gset = GeneralSettings::first();
      $this->sitename = $Gset->website_title;
    }

    public function index() {
      $gateways = Gateway::all();
      $data['sitename'] = $this->sitename;
      $data['page_title'] = 'Gateway Setting';
      return view('admin.gateway.index', ['gateways' => $gateways, 'data' => $data]);
    }

    public function update(Request $request, $gatewayID) {
      $messages = [
        'gateimg.mimes' => 'Gateway logo must be a file of type: jpeg, jpg, png.',
        'minamo.required' => 'Minimum Limit Per Transaction is required',
        'minamo.numeric' => 'Minimum Limit Per Transaction must be number',
        'maxamo.required' => 'Maximum Limit Per Transaction is required',
        'maxamo.numeric' => 'Maximum Limit Per Transaction must be number',
        'chargefx.required' => 'Fixed Charge is required',
        'chargefx.numeric' => 'Fixed Charge must be number',
        'chargepc.required' => 'Charge in Percentage is required',
        'chargepc.numeric' => 'Charge in Percentage must be number',

      ];
      $validatedData = $request->validate([
          'name' => 'required',
          'gateimg' => 'mimes:jpeg,jpg,png',
          'minamo' => 'required|numeric',
          'maxamo' => 'required|numeric',
          'chargefx' => 'required|numeric',
          'chargepc' => 'required|numeric',
      ], $messages);
      $gateway = Gateway::find($gatewayID);
      $gateway->name = $request->name;
      $gateway->minamo = $request->minamo;
      $gateway->maxamo = $request->maxamo;
      if($request->hasFile('gateimg')) {
        if(!empty($gateway->gateimg)) {
          $imagePath = './assets/users/img/gateway/' . $gateway->gateimg;
          unlink($imagePath);
        }
        $image = $request->file('gateimg');
        $fileName = time() . '.jpg';
        $location = './assets/users/img/gateway/' . $fileName;
        Image::make($image)->resize(800, 800)->save($location);
        $gateway->gateimg = $fileName;
      }
      $gateway->chargefx = $request->chargefx;
      $gateway->chargepc = $request->chargepc;
      if ($gatewayID == 1) {
        $gateway->val1 = $request->val1;
      }
      if ($gatewayID == 2) {
        $gateway->val1 = $request->val1;
        $gateway->val2 = $request->val2;
      }
      if($gatewayID == 3) {
        $gateway->val1 = $request->val1;
        $gateway->val2 = $request->val2;
      }
      if($gatewayID == 4) {
        $gateway->val1 = $request->val1;
        $gateway->val2 = $request->val2;
      }
      if($gatewayID == 5) {
        $gateway->val1 = $request->val1;
        $gateway->val2 = $request->val2;
      }
      if($gatewayID == 6) {
        $gateway->val1 = $request->val1;
        $gateway->val2 = $request->val2;
        $gateway->val3 = $request->val3;
      }
      if($gatewayID == 7) {
        $gateway->val1 = $request->val1;
        $gateway->val2 = $request->val2;
      }
      if($gatewayID == 8) {
        $gateway->val1 = $request->val1;
        $gateway->val2 = $request->val2;
      }
      $gateway->status = $request->status;

      $gateway->save();

      Session::flash('success', $gateway->name.' informations updated successfully!');

      return redirect()->back();
    }
}
