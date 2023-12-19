<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campground extends Model
{
    protected $fillable = [
        'title', 'slug','summary', 'description','location','lat','lng', 'is_featured', 'cat_id', 'child_cat_id', 'condition',
        'photo', 'status'
        // Add other fields as needed
    ];



    public function category()
    {
        return $this->belongsTo(CampgroundCategory::class ,'cat_id');
    }

    public function subCategory()
    {
        return $this->belongsTo(CampgroundCategory::class,'child_cat_id');
    }

    public static function getCampgroundBySlug($slug)
    {
        return Campground::with(['category'])->where('slug', $slug)->first();
    }

    
}
