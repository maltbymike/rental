<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\HomepageCarouselRequest;

use App\HomepageCarousel;

class HomepageController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth')->except(['index']);
  }

  public function index()
  {
    $images = HomepageCarousel::where('inactive', 0)->get();

    return view('index', compact('images'));
  }

  public function editSettings()
  {
    $images = HomepageCarousel::where('inactive', 0)->get();

    return view('webadmin.settings.homepage', compact('images'));
  }

  public function updateSettings(Request $request)
  {
    if (request()->hasFile('image'))
    {
      $filename = request()->file('image')->store('homepage-carousel', 'images');

      $image = new HomepageCarousel;
      $image->filename = $filename;
      $image->title = request()->title;
      $image->caption = request()->caption;
      $image->button_text = request()->button_text;
      $image->link_to = request()->link_to;
      $image->inactive = request()->inactive;
      $image->save();

      session()->flash('status', "Slider Image Added Successfully!");
    }

    return redirect('/settings/homepage');
  }

}
