<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Image;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('image.image');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      if($request->hasFile('image')) {
        // get filename with extension
        $filenameWithExtension = $request->file('image')->getClientOriginalName();

        // get filename without extension
        $filename = pathinfo($filenameWithExtension, PATHINFO_FILENAME);

        // get file extension
        $extension = $request->file('image')->getClientOriginalExtension();

        // filename to Store
        $filenameToStore = $filename.'_'.time().'.'.$extension;

        // Upload file
        $request->file('image')->storeAs('public/images/upload', $filenameToStore);

        if(!file_exists(public_path('storage/images/crop'))) {
          mkdir(public_path('storage/images/crop'), 0755);
        }

        // Crop image
        $img = Image::make(public_path('storage/images/upload/' . $filenameToStore));
        $croppath = public_path('storage/images/crop/' . $filenameToStore);

        $img->crop($request->input('w'), $request->input('h'), $request->input('x1'), $request->input('y1'));
        $img->save($croppath);

        // Get croppath to save in database
        $path = asset('storage/images/crop/' . $filenameToStore);

        return redirect('image')->with(['success' => "Image cropped Successfully.", 'path' => $path]);
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
