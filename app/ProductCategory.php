<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\ProductCategory;
use App\Product;

class ProductCategory extends Model
{
    protected $dates = ['deleted_at'];
    protected $guarded = [];

    public function getRouteKeyName()
    {
      return 'slug';
    }

    public function parent()
    {
      return $this->belongsTo(ProductCategory::class, 'parent_id');
    }

    public function children()
    {
      return $this->hasMany(ProductCategory::class, 'parent_id');
    }

    public function activeChildren()
    {
      return $this->hasMany(ProductCategory::class, 'parent_id')->where('inactive', '0');
    }

    public function products()
    {
      return $this->belongsToMany(Product::class)
        ->with('rates')
        ->withTimestamps();
    }

    public function productsWithRates()
    {
      return $this->belongsToMany(Product::class)
        ->where('inactive', '0')
        ->where('hide_on_website', '0')
        ->where('quantity', ">", '0')
        ->where(function ($query) {
          $query->whereIn('type', ['T', 'U', 'H', ])
                ->whereNull('header')
                ->orWhereIn('type', ["V", "K", "D"]);
        })
        ->with('rates')
        ->withTimestamps();
    }

}
