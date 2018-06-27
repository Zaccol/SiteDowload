<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GeneralSettings as GS;
use App\Category as Category;
use App\GeneralSettings;
use Session;

class CategoryManagementController extends Controller
{
    public function __construct() {
      $gs = GS::first();
      $this->sitename = $gs->website_title;
    }

    public function index() {
      $data['sitename'] = $this->sitename;
      $data['page_title'] = 'Email Setting';
      $categories = Category::where('deleted', 0)->paginate(10);
      return view('admin.categoryManagement.index', ['data' => $data, 'categories' => $categories]);
    }

    public function store(Request $request) {
      $request->validate([
        'category' => 'required',
      ]);
      $category = new Category;
      $category->name = $request->category;
      $category->save();
      Session::flash('success', 'New category added successfully!');
      return redirect()->back();
    }

    public function update(Request $request, $categoryID) {
        $request->validate([
          'category' => 'required',
        ]);
        $category = Category::find($categoryID);
        $category->name = $request->category;
        $category->save();
        Session::flash('success', 'Category updated successfully!');
        return redirect()->back();
    }

    public function delete(Request $request, $categoryID) {
        $category = Category::find($categoryID);
        // $category->delete();
        $category->deleted = 1;
        $category->save();
        Session::flash('success', 'Category deleted successfully!');
        return redirect()->back();
    }
}
