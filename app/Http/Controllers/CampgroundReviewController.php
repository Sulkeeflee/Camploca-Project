<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campground;
use App\Models\CampgroundReview;
use App\Notifications\StatusNotification;
use App\User;
use Illuminate\Support\Facades\Notification;

class CampgroundReviewController extends Controller
{
    public function index()
    {
        $reviews = CampgroundReview::getAllReview();

        return view('backend.campgroundreview.index')->with('reviews', $reviews);
    }

    public function create()
    {
        // Implement if needed
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'rate' => 'required|numeric|min:1',
        ]);

        $campgroundInfo = Campground::getCampgroundBySlug($request->slug);

        $data = $request->all();
        $data['campground_id'] = $campgroundInfo->id;
        $data['user_id'] = $request->user()->id; 
        $data['status'] = 'active';

        $status = CampgroundReview::create($data);

        $adminUsers = User::where('role', 'admin')->get();
        $details = [
            'title' => 'New Campground Rating!',
            'actionURL' => route('campground-detail', $campgroundInfo->slug),
            'fas' => 'fa-star',
        ];
        Notification::send($adminUsers, new StatusNotification($details));

        if ($status) {
            request()->session()->flash('success', 'Thank you for your feedback');
        } else {
            request()->session()->flash('error', 'Something went wrong! Please try again!!');
        }

        return redirect()->back();
    }

    public function edit($id)
    {
        $review = CampgroundReview::find($id);

        return view('backend.campgroundreview.edit')->with('review', $review);
    }

    public function update(Request $request, $id)
    {
        $review = CampgroundReview::find($id);

        if ($review) {
            $data = $request->all();
            $status = $review->fill($data)->update();

            if ($status) {
                request()->session()->flash('success', 'Review successfully updated');
            } else {
                request()->session()->flash('error', 'Something went wrong! Please try again!!');
            }
        } else {
            request()->session()->flash('error', 'Review not found!!');
        }

        return redirect()->route('campground-review.index');
    }

    public function destroy($id)
    {
        $review = CampgroundReview::find($id);
        $status = $review->delete();

        if ($status) {
            request()->session()->flash('success', 'Successfully deleted review');
        } else {
            request()->session()->flash('error', 'Something went wrong! Try again');
        }

        return redirect()->route('campground-review.index');
    }
}

