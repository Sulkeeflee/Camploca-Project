<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campground;
use App\Models\CampgroundCategory;
use Illuminate\Support\Str;

class CampgroundController extends Controller
{
    public function index()
    {
        $campgrounds = Campground::with(['category', 'subCategory'])->orderBy('id', 'desc')->paginate(10);

        return view('backend.campground.index')->with('campgrounds', $campgrounds);
    }

    public function create()
    {
        $categories = CampgroundCategory::all();
        return view('backend.campground.create')->with('categories', $categories);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'summary' => 'required',
            'description' => 'nullable|string',
            'location' => 'nullable|string',
            'lat' => 'nullable|decimal',
            'lng' => 'nullable|decimal',
            'is_featured' => 'sometimes|in:1',
            'cat_id' => 'required|exists:categories,id',
            'child_cat_id' => 'nullable|exists:categories,id',
            'condition' => 'nullable|string',
            'photo' => 'required|string',
            'status' => 'required|in:active,inactive',
        ]);


        $data=$request->all(); 
        $slug=Str::slug($request->title);
        $count=Campground::where('slug',$slug)->count();
        if($count>0){
            $slug=$slug.'-'.date('ymdis').'-'.rand(0,999);
        }
        $data['slug']=$slug;
        $data['is_featured']=$request->input('is_featured',0);
        
        // return $size;
        // return $data;
        $campground = Campground::create($data);
        if($campground){
            request()->session()->flash('success', 'Campground successfully added');
        }
        else{
            request()->session()->flash('error','Please try again!!');
        }
        return redirect()->route('campground.index');

    }

    public function edit($id)
    {
        $campground = Campground::findOrFail($id);
        $categories = CampgroundCategory::all();

        return view('backend.campground.edit')->with('campground', $campground)->with('categories', $categories);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'summary' => 'required|string',
            'description' => 'nullable|string',
            'is_featured' => 'sometimes|in:1',
            'cat_id' => 'required|exists:categories,id',
            'child_cat_id' => 'nullable|exists:categories,id',
            'condition' => 'nullable|string',
            'photo' => 'required|string',
            'status' => 'required|in:active,inactive',
        ]);

        $data = $request->all();
        $campground = Campground::findOrFail($id);
        $campground->update($data);

        return redirect()->route('campground.index')->with('success', 'Campground successfully updated');
    }

    public function destroy($id)
    {
        $campground = Campground::findOrFail($id);
        $campground->delete();

        return redirect()->route('campground.index')->with('success', 'Campground successfully deleted');
    }
}
