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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->getCategoryDataForSelectOption();
        $types = ProductType::select('type_code', 'name')->orderby('name')->get()->toArray();

        return view('product.create', compact('categories', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
      $loggedIn = Auth::check();
      $images = $product->images()->get();

      return view('product.show', compact('product', 'loggedIn', 'images'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
      $categories = $this->getCategoryDataForSelectOption();
      $images = $product->images()->get();
      $types = ProductType::select('type_code', 'name')->orderby('name')->get()->toArray();

      return view('product.edit', compact('product', 'categories', 'images', 'types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
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
      // get file from upload
      $path = request()->file('file')->getRealPath();

      // turn into array
      $file = file($path);

      // grab header line
      $header = current($file);

      // remove header line
      $data = array_slice($file, 1);

      // Loop through file into parts
      $parts = (array_chunk($data, 500));
      $i = 1;
      foreach($parts as $part)
      {
        $filename = base_path('resources/pendingproducts-' . date('ymdHis') . "-$i.csv");
        array_unshift($part, $header);
        file_put_contents($filename, $part, FILE_APPEND);
        $i++;
      }

      session()->flash('status', 'Products Queued for Import');

      return redirect('/webadmin');
    }

    public function processUpload_old(ProductUploadCSVRequest $request)
    {
      $filename = request()->file('file')->storeAs('', 'csv_upload.csv', 'upload');
      $path = storage_path('app/upload/' . $filename);

      $categories = ProductCategory::all();

      $data = $this->getDataFromCSV($path);

      $line = 1;
      foreach ($data as $row)
      {
        $validated = $this->validateCSVRow($row, $line);

        // Update or Create product
        $product = Product::updateOrCreate(
          ['por_id' => $row['por_id']],
          [
            'product_key' => $row['product_key'],
            'name' => $row['name'],
            'quantity' => $row['quantity'],
            'type' => $row['type'],
            'part_number' => $row['part_number'],
            'model' => $row['model'],
            'header' => $row['header'],
            'inactive' => $row['inactive'],
            'hide_on_website' => $row['hide_on_website'],
            'weight' => $row['weight'],
            'slug' => str_slug($row['name'] . '-' . $row['product_key']),
          ]
        );

        // Get manufacturer_id and unset manufacturer
        if ($row['manufacturer'])
        {
          $manufacturer = ProductManufacturer::firstOrCreate(['name' => $row['manufacturer']]);
          $product->manufacturer()->associate($manufacturer);
          $product->save();
        }

        // create rates
        foreach ($row['rates'] as $rate)
        {
          if (!empty($rate['time']))
          {
            $data = [
              'hours' => $rate['time'],
              'rate' => $rate['rate']
            ];

            $updateRate = $product->rates()->where('hours', $data['hours'])->first() ?: new ProductRate($data);

            $updateRate->hours = $data['hours'];
            $updateRate->rate = $data['rate'];

            $product->rates()->save($updateRate);
          }
        }

        // Associate category
        if ($row['por_category'])
        {
          $category = ProductCategory::firstOrCreate(
            ['por_id' => $row['por_category']],
            [
              'name' => 'Category Added From CSV Import',
              'slug' => $row['por_category'],
            ]
          );
          $product->categories()->attach($category);
          $product->save();
        }

        $line++;
      }

      session()->flash('status', "CSV Import was a success!");

      return redirect("/product/category");

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

    public function getDBFields()
    {
      return [
        'KEY' => 'product_key',
        'PartNumber' => 'part_number',
        'NUM' => 'por_id',
        'NAME' => 'name',
        'QTY' => 'quantity',
        'TYPE' => 'type',
        'MANF' => 'manufacturer',
        'MODN' => 'model',
        'Header' => 'header',
        'Inactive' => 'inactive',
        'HideOnWebsite' => 'hide_on_website',
        'Weight' => 'weight',
        'Category' => 'por_category',
        'PER1' => 'PER|1',
        'PER2' => 'PER|2',
        'PER3' => 'PER|3',
        'PER4' => 'PER|4',
        'PER5' => 'PER|5',
        'PER6' => 'PER|6',
        'PER7' => 'PER|7',
        'PER8' => 'PER|8',
        'RATE1' => 'RATE|1',
        'RATE2' => 'RATE|2',
        'RATE3' => 'RATE|3',
        'RATE4' => 'RATE|4',
        'RATE5' => 'RATE|5',
        'RATE6' => 'RATE|6',
        'RATE7' => 'RATE|7',
        'RATE8' => 'RATE|8',
      ];
    }

    public function getDataFromCSV($filename)
    {
      $data = $header = [];
      $i = 0;
      $fields = $this->getDBFields();

      $file = @fopen($filename, 'r');
      if ($file)
      {
        while(($row = fgetcsv($file)) !== false)
        {
          if (empty($header))
          {
            $header = $row;
            continue;
          }

          foreach ($row as $key => $value)
          {
            if (isset($fields[$header[$key]]))
            {
              if (substr($fields[$header[$key]], 0, 3) == "PER")
              {
                $getRateNumber = explode("|", $fields[$header[$key]]);
                $data[$i]['rates'][$getRateNumber[1]]['time'] = $value;
              }
              elseif (substr($fields[$header[$key]], 0, 4) == 'RATE')
              {
                $getRateNumber = explode("|", $fields[$header[$key]]);
                $data[$i]['rates'][$getRateNumber[1]]['rate'] = $value;
              }
              else
              {
                if ($value == "True")
                {
                  $value = 1;
                }
                elseif ($value == 'False')
                {
                  $value = 0;
                }
                $data[$i][$fields[$header[$key]]] = $value;
              }
            }
          }

          $i++;
        }
      }
      return $data;
    }

    public function validateCSVRow($row, $line)
    {
      $csv_errors = Validator::make(
        $row,
        (new ProductRequest)->rules()
      )->errors();

      if ($csv_errors->any())
      {
        return redirect()->back()
          ->withErrors($csv_errors)
          ->with('error_line', $line);
      }

      return $row;
    }
}
