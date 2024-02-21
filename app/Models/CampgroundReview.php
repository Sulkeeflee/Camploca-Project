<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 
class CampgroundReview extends Model 
{
    protected $fillable = ['user_id', 'campground_id', 'rate', 'review', 'status'];

    public function user_info()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public static function getAllReview()
    {
        return CampgroundReview::with('user_info')->paginate(10); 
    }

    public static function getAllUserReview()
    {
        return CampgroundReview::where('user_id', auth()->user()->id)->with('user_info')->paginate(10);
    }

    public function campground()
    {
        return $this->hasOne(Campground::class, 'id', 'campground_id');
    }
    
}

