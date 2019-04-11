<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = ['filename'];

    public function products()
    {
      return $this->belongsToMany(Product::class, 'product_id');
    }

    public function type()
    {
      return $this->belongsTo(ImageType::class, 'image_type_id');
    }

}
