<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campground;
use App\Models\Product;


class CampgroundProductController extends Controller
{
    public function index()
    {
        $campgrounds = Campground::getAllUserCampground();
        $products = Product::all();
        return view('user.campground.campground_product', compact('campgrounds', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'campground_id' => 'required|exists:campgrounds,id',
            'products' => 'required|array',
            'products.*' => 'exists:products,id',
        ]);

        $data = $request->all();
        $data['user_id'] = $request->user()->id;
        $campground = Campground::findOrFail($request->campground_id);
        $campground->products()->attach($request->products);

        return redirect()->route('campground.product.index')->with('success', 'Products added to campground successfully.');
    }

    public function destroy($campgroundId, $productId)
    {
        $campground = Campground::findOrFail($campgroundId);
        $campground->products()->detach($productId);
    
        return redirect()->back()->with('success', 'Product removed from campground successfully.');
    }
    
    

    public function campgroundProducts()
    {
        $campgrounds = Campground::all();
        $products = Product::all();
        return view('backend.campground.campground_product', compact('campgrounds', 'products'));
    }

    public function campgroundProductsStore(Request $request)
    {
        $request->validate([
            'campground_id' => 'required|exists:campgrounds,id',
            'products' => 'required|array',
            'products.*' => 'exists:products,id',
        ]);

        $campground = Campground::findOrFail($request->campground_id);
        $campground->products()->attach($request->products);

        return redirect()->route('backend.campground.product.index')->with('success', 'Products added to campground successfully.');
    }
}

