<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Image;

class ImageType extends Model
{
  public function getRouteKeyName()
  {
    return 'slug';
  }

  public function images()
  {
    return $this->hasMany(Image::class, 'image_type_id');
  }
}
