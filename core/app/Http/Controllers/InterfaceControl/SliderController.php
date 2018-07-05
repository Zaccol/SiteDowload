<?php

namespace App\Http\Controllers\InterfaceControl;

use Illuminate\Http\Request;
use App\GeneralSettings as GS;
use App\Slider as Slider;
use App\Http\Controllers\Controller;
use Image;
use Session;

class SliderController extends Controller
{
    public function __construct() {
      $gs = GS::first();
      $this->sitename = $gs->website_title;
    }

    public function index() {
      $data['sitename'] = $this->sitename;
      $data['page_title'] = 'Email Setting';
      $sliders = Slider::all();
      return view('admin.interfaceControl.slider.index', ['data' => $data, 'sliders' => $sliders]);
    }

    public function store(Request $request) {
      $messages = [
        'btext.required' => 'bold text field is required',
        'stext.required' => 'small text field is required',
      ];
      $validatedData = $request->validate([
          'slider' => 'required|mimes:jpeg,jpg,png',
          'btxt' => 'required',
          'stxt' => 'required'
      ], $messages);

      $slider = new Slider;
      $slider->small_text = $request->stxt;
      $slider->bold_text = $request->btxt;
      if($request->hasFile('slider')) {
        $image = $request->file('slider');
        $fileName = time() . '.jpg';
        $location = './assets/users/interfaceControl/slider_images/' . $fileName;
        Image::make($image)->resize(1360, 550)->save($location);
        $slider->image = $fileName;
      }
      $slider->save();
      Session::flash('success', 'Slider image added successfully!');
      return redirect()->back();
    }

    public function delete(Request $request) {
      $slider = Slider::find($request->sliderID);
      if(!empty($slider->image)) {
        $imagePath = './assets/users/interfaceControl/slider_images/' . $slider->image;
        unlink($imagePath);
      }
      $slider->delete();

      Session::flash('success', 'Slider image deleted successfully!');
      return redirect()->back();
    }
}
