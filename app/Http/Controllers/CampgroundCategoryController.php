<?php

namespace App\Http\Controllers;

use App\Models\CampgroundCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CampgroundCategoryController extends Controller
{
    /**  
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $campgroundCategories = CampgroundCategory::getAllCategory();
        return view('backend.campgroundcategory.index')->with('campgroundCategories', $campgroundCategories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parent_cats = CampgroundCategory::where('is_parent', 1)->orderBy('title', 'ASC')->get();
        return view('backend.campgroundcategory.create')->with('parent_cats', $parent_cats);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'string|required',
            'is_parent'=>'sometimes|in:1',
            'parent_id'=>'nullable|exists:categories,id',
            'status' => 'required|in:active,inactive'
            
        ]);

        $data = $request->all(); 
        $slug = Str::slug($request->title);
        $count = CampgroundCategory::where('slug', $slug)->count();

        if ($count > 0) {
            $slug = $slug . '-' . date('ymdis') . '-' . rand(0, 999);
        } 

        $data['slug'] = $slug;
        $data['is_parent']=$request->input('is_parent',0);

        $status = CampgroundCategory::create($data);

        if ($status) {
            request()->session()->flash('success', 'Campground Category successfully added');
        } else {
            request()->session()->flash('error', 'Please try again!!');
        }

        return redirect()->route('campground-category.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $parent_cats = CampgroundCategory::where('is_parent', 1)->get();
        $campgroundCategory = CampgroundCategory::findOrFail($id);
        return view('backend.campgroundcategory.edit')->with('campgroundCategory', $campgroundCategory)->with('parent_cats', $parent_cats);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'string|required',
            'is_parent'=>'sometimes|in:1',
            'parent_id'=>'nullable|exists:categories,id',
            'status' => 'required|in:active,inactive'
        ]);

        $data = $request->all();
        $slug = Str::slug($request->title);
        $count = CampgroundCategory::where('slug', $slug)->where('id', '!=', $id)->count();

        if ($count > 0) {
            $slug = $slug . '-' . date('ymdis') . '-' . rand(0, 999);
        }

        $data['slug'] = $slug;
        $data['is_parent']=$request->input('is_parent',0);
        
        $campgroundCategory = CampgroundCategory::findOrFail($id);
        $status = $campgroundCategory->update($data);

        if ($status) {
            request()->session()->flash('success', 'Campground Category successfully updated');
        } else {
            request()->session()->flash('error', 'Please try again!!');
        }

        return redirect()->route('campground-category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $campgroundCategory = CampgroundCategory::findOrFail($id);
        $status = $campgroundCategory->delete();

        if ($status) {
            request()->session()->flash('success', 'Campground Category successfully deleted');
        } else {
            request()->session()->flash('error', 'Please try again!!');
        }

        return redirect()->route('campground-category.index');
    }
}
