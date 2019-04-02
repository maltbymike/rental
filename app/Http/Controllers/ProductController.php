<?php

namespace App\Http\Controllers;

use Validator;

use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductUploadCSVRequest;
use Illuminate\Support\Facades\Auth;

use App\CsvData;
use App\Image;
use App\Product;
use App\ProductCategory;
use App\ProductType;
use App\ProductRate;
use App\ProductManufacturer;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }


    public function index()
    {
      if ($loggedIn = Auth::check())
      {
        $products = Product::all();
      }
      else
      {
        $products = Product::where('inactive', 0)->get();
      }

      return view('product.index', compact('products', 'loggedIn'));

    }


    public function create()
    {
        $categories = $this->getCategoryDataForSelectOption();
        $types = ProductType::select('type_code', 'name')->orderby('name')->get()->toArray();

        return view('product.create', compact('categories', 'types'));
    }


    public function store(ProductRequest $request)
    {
        DB::transaction(function()
        {

         // Create Product
          $product = Product::create($this->getProductAttributes());

          // Get manufacturer_id and unset manufacturer
          if (request()->manufacturer)
          {
            $manufacturer = ProductManufacturer::firstOrCreate(['name' => request()->manufacturer]);
            $product->manufacturer()->associate($manufacturer);
            $product->save();
          }

          // create rates
          foreach (request()->rates as $rate)
          {
            if (!empty($rate['time']))
            {
              $product_rate[] = new ProductRate ([
                'hours' => $rate['time'] * $rate['period'],
                'rate' => $rate['rate']
              ]);
            }
            $product->rates()->saveMany($product_rate);
          }

          // create product_category map
          $product->categories()->attach(request()->input('categories'));

          // add images
          if (request()->hasFIle('images'))
          {
            $this->addImages($product, request()->file('images'));
          }

        session()->flash('status', "Product: $product->name was created successfully!");
        });

        return redirect('/product');
    }


    public function show(Product $product)
    {
      $loggedIn = Auth::check();
      $images = $product->images()->get();

      return view('product.show', compact('product', 'loggedIn', 'images'));
    }

    public function edit(Product $product)
    {
      $categories = $this->getCategoryDataForSelectOption();
      $images = $product->images()->get();
      $types = ProductType::select('type_code', 'name')->orderby('name')->get()->toArray();

      return view('product.edit', compact('product', 'categories', 'images', 'types'));
    }


    public function update(ProductRequest $request, Product $product)
    {
      DB::transaction(function() use ($product)
      {

        // Create Product
        $product->update($this->getProductAttributes());

        // Get manufacturer_id and unset manufacturer
        if (request()->manufacturer)
        {
          $manufacturer = ProductManufacturer::firstOrCreate(['name' => request()->manufacturer]);
          $product->manufacturer()->associate($manufacturer);
          $product->save();
        }

        // create rates
        foreach (request()->rates as $rate)
        {
          if (!empty($rate['time']))
          {
            $data = [
              'hours' => $rate['time'] * $rate['period'],
              'rate' => $rate['rate']
            ];

            $updateRate = $product->rates()->where('hours', $data['hours'])->first() ?: new ProductRate($data);

            $updateRate->hours = $data['hours'];
            $updateRate->rate = $data['rate'];

            $product->rates()->save($updateRate);
          }
        }

        // create product_category map
        $product->categories()->sync(request()->input('categories'));

        // upload images
        if (request()->hasFIle('images'))
        {
          foreach (request()->file('images') as $image)
          {
            $filename = $image->storeAs('product', $product->slug . "_" . date("Ymd_His") . "." . $image->getClientOriginalExtension(), 'images');
            $imageStored = Image::create([
              'filename' => $filename
            ]);

            $uploadedImages[] = $imageStored->id;
          }
          $product->images()->attach($uploadedImages);
        }

      session()->flash('status', "Product: $product->name was updated successfully!");
      });

      return redirect("/product/" . $product->slug);
    }


    public function destroy(Product $product)
    {
      $product->delete();

      return redirect('/product/category');
    }


    public function upload()
    {
      return view('product.upload.index');
    }


    public function processUpload(ProductUploadCSVRequest $request)
    {
      $path = request()->file('file')->getRealPath();

      $file = file($path);  // turn into array

      $header = current($file);  // grab header line
      $data = array_slice($file, 1);    // remove header line from array

      $parts = (array_chunk($data, 500));
      $i = 1;
      foreach($parts as $part)
      {
        $filename = base_path('resources/pendingproducts/' . date('ymdHis') . "-$i.csv");
        array_unshift($part, $header);
        file_put_contents($filename, $part, FILE_APPEND);
        $i++;
      }

      session()->flash('status', 'Products Queued for Import');

      return redirect('/webadmin');
    }


    public function addImages($product, $images)
    {
        foreach ($images as $image)
        {
          $filename = $image->storeAs('product', $product->slug . "_" . date("Ymd_His") . "." . $image->getClientOriginalExtension(), 'images');
          $imageStored = Image::create([
            'filename' => $filename
          ]);

          $uploadedImages[] = $imageStored->id;
        }
        return $product->images()->attach($uploadedImages);
    }

    public function getCategoryDataForSelectOption()
    {
      $categories = ProductCategory::where('parent_id', null)->with(['children' => function ($query) {
        $query->select('name', 'id', 'parent_id');
      }])->select('name', 'id', 'parent_id')->get();

      return $categories;
    }

    public function getProductAttributes()
    {
      $attributes = [
        'type' => request('type'),
        'name' => request('name'),
        'description' => request('description'),
        'product_key' => request('product_key'),
        'part_number' => request('part_number'),
        'por_id' => request('por_id'),
        'header' => request('header'),
        'quantity' => request('quantity'),
        'slug' => request('slug'),
        'model' => request('model'),
        'inactive' => request('inactive'),
        'hide_on_website' => request('hide_on_website')
      ];

      $attributes['slug'] = $attributes['slug'] ?: str_slug($attributes['name']);

      return $attributes;

    }
}
