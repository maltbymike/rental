<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\ProductCategory;
use App\Product;

class ProductCategory extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $guarded = [];

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
      return $this->belongsToMany(Product::class)->withTimestamps();
    }
}
