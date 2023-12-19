<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampgroundCategory extends Model
{
    protected $fillable=['title','slug','is_parent','status'];

    public function campground(){
        return $this->hasMany('App\Models\campground','post_cat_id','id')->where('status','active');
    }

    public static function getBlogByCategory($slug){
        return CampgroundCategory::with('campground')->where('slug',$slug)->first();
    }
}
 