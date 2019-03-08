<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Product;
use App\ProductCategory;

class Product extends Model
{
  use SoftDeletes;
  protected $dates = ['deleted_at'];

  protected $guarded = [];

  public function manufacturer()
  {
    return $this->belongsTo(ProductManufacturer::class, 'manufacturer_id');
  }

  public function rates()
  {
    return $this->hasMany(ProductRate::class, 'product_id')->orderBy('hours');
  }

  public function categories()
  {
    return $this->belongsToMany(ProductCategory::class)->withTimestamps();
  }
}
