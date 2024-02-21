<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campground extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'title', 'slug', 'summary', 'description', 'location', 'lat', 'lng', 'is_featured', 'cat_id', 'child_cat_id', 'condition',
        'photo','added_by','status'
        // Add other fields as needed
    ];
  
    
    public function category()
    {
        return $this->hasOne('App\Models\CampgroundCategory', 'id', 'cat_id');
    }

    public function subCategory()
    {
        return $this->hasOne('App\Models\CampgroundCategory', 'id', 'child_cat_id');
    }
 
    public function author_info(){
        return $this->hasOne('App\User','id','added_by');
    }
    
    public static function getAllCampgrounds()
    {
        return Campground::with(['category', 'author_info','subCategory'])
            ->orderBy('id', 'desc') 
            ->paginate(10);
    }

    public function relatedCampgrounds()
    {
        return $this->hasMany('App\Models\Campground', 'cat_id', 'cat_id')
            ->where('status', 'active')
            ->orderBy('id', 'DESC')
            ->limit(8);
    }

    public function getReview()
    {
        return $this->hasMany('App\Models\CampgroundReview', 'campground_id', 'id')
            ->with('user_info')
            ->where('status', 'active')
            ->orderBy('id', 'DESC');
    }

    public static function getCampgroundBySlug($slug)
    {
        return Campground::with(['category', 'author_info', 'relatedCampgrounds', 'getReview'])
            ->where('slug', $slug)
            ->first();
    }

    public static function countActiveCampgrounds()
    {
        $data = Campground::where('status', 'active')->count();
        return $data ?: 0;
    }

    public function user_info()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public static function getAll()
    {
        return Campground::with('user_info')->paginate(10); 
    }

    public static function getAllUser()
    {
        return Campground::where('user_id', auth()->user()->id)->with('user_info')->paginate(10);
    }

    public static function getAllUserCampground(){
        return Campground::where('user_id',auth()->user()->id)->with('user_info')->paginate();
    }
    public static function countActiveCampground(){
        $data=Campground::where('status','active')->count();
        if($data){
            return $data;
        }
        return 0;
    }
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
