<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampgroundCategory extends Model
{
    protected $fillable = ['title', 'slug', 'is_parent', 'status', 'parent_id', 'added_by'];

    public function parent_info()
    {
        return $this->hasOne(CampgroundCategory::class, 'id', 'parent_id');
    }

    public static function getAllCategory()
    {
        return CampgroundCategory::orderBy('id', 'DESC')->with('parent_info')->paginate(10);
    }

    public static function shiftChild($cat_id)
    {
        return CampgroundCategory::whereIn('id', $cat_id)->update(['is_parent' => 1]);
    }

    public static function getChildByParentID($id)
    {
        return CampgroundCategory::where('parent_id', $id)->orderBy('id', 'ASC')->pluck('title', 'id');
    }

    public function child_cat()
    {
        return $this->hasMany(CampgroundCategory::class, 'parent_id', 'id')->where('status', 'active');
    }

    public static function getAllParentWithChild()
    {
        return CampgroundCategory::with('child_cat')->where('is_parent', 1)->where('status', 'active')->orderBy('title', 'ASC')->get();
    }

    public function campgrounds()
    {
        return $this->hasMany(Campground::class, 'cat_id', 'id')->where('status', 'active');
    }

    public function sub_campgrounds()
    {
        return $this->hasMany(Campground::class, 'child_cat_id', 'id')->where('status', 'active');
    }

    public static function getCampgroundByCat($slug)
    {
        $category = CampgroundCategory::with('campgrounds')->where('slug', $slug)->first();

        if ($category) {
            return $category->campgrounds;
        }

        // Handle case when category is not found
        throw new \Exception("Campground category with slug '$slug' not found.");
    }

    public static function getCampgroundBySubCat($slug)
    {
        $category = CampgroundCategory::with('sub_campgrounds')->where('slug', $slug)->first();

        if ($category) {
            return $category->sub_campgrounds;
        }

        // Handle case when sub category is not found
        throw new \Exception("Sub campground category with slug '$slug' not found.");
    }

    

    public static function countActiveCampgroundCategory(){
        $data=CampgroundCategory::where('status','active')->count();
        if($data){
            return $data;
        }
        return 0;
    }
}
