<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Product;
use App\ProductCategory;

class Product extends Model
{
  protected $dates = ['deleted_at'];

  protected $guarded = [];

  public function getRouteKeyName()
  {
    return 'slug';
  }

  public function parent()
  {
    return $this->belongsTo(Product::class, 'header', 'product_key');
  }

  public function children()
  {
    return $this->hasMany(Product::class, 'header', 'product_key');
  }

  public function activeChildren()
  {
    return $this->hasMany(Product::class, 'header', 'product_key')
      ->where('inactive', '0')
      ->where('hide_on_website', '0')
      ->where('quantity', ">", "0");
  }

  public function categories()
  {
    return $this->belongsToMany(ProductCategory::class)->withTimestamps();
  }

  public function images()
  {
    return $this->belongsToMany(Image::class)->withTimestamps();
  }

  public function manufacturer()
  {
    return $this->belongsTo(ProductManufacturer::class, 'manufacturer_id');
  }

  public function rates()
  {
    return $this->hasMany(ProductRate::class, 'product_id')->orderBy('hours');
  }
}
