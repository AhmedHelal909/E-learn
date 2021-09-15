<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Category extends Model implements TranslatableContract
{
    use Translatable;

    public $translatedAttributes = ['name', 'description'];

    protected $guarded = [];

    protected $appends = ['image_path', 'children_array'];

    public function getImagePathAttribute(){
        return $this->image != null ? asset('uploads/category_images/'.$this->image) :  asset('uploads/category_images/default.png') ;
    }
    
    public function getChildrenArrayAttribute(){
        return $this->children()->pluck('id')->toArray();
    }

    public function products()
    {
        return $this->hasMany(Product::class)->orderBy('rate','desc');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function product()
    {
        return $this->hasMany(Product::class, );
    }

}
