<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Product;

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
    return $this->hasMany(ProductRate::class, 'product_id');
  }
}
