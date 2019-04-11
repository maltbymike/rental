<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\ImageType;

class ImageController extends Controller
{
    public function addImage($image, $type)
    {
      $filename = $image->store($type, 'images');
      $imageStored = Image::create([
        'filename' => $filename
      ]);

      return $imageStored->id;
    }
}
