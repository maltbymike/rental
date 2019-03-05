<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductCategory;
use App\ProductType;
use App\ProductRate;
use App\ProductManufacturer;

use Illuminate\Support\Facades\DB;
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
        //
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
    public function store(Request $request)
    {
        DB::transaction(function()
        {
          $attributes = $this->validateProduct();
          $attributes['slug'] = $attributes['slug'] ?: str_slug($attributes['name']);
          $attributes['manufacturer_id'] = $this->getOrAddManufacturer($attributes['manufacturer']);
          unset($attributes['manufacturer']);

          $rates = $this->validateRates();

          $product = Product::create($attributes);

          foreach ($rates as $rate)
          {
            foreach ($rate as $line)
            {
              if (!empty($line['time']))
              {
                $product_rate = new ProductRate;
                $product_rate->product_id = $product->id;
                $product_rate->hours = $line['time'] * $line['period'];
                $product_rate->rate = $line['rate'];
                $product_rate->save();
              }
            }
          }

        session()->flash('status', "Prodct: {$attributes['name']} was created successfully!");
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }

    public function getCategoryDataForSelectOption()
    {
      $categories = ProductCategory::where('parent_id', null)->with(['children' => function ($query) {
        $query->select('name', 'id', 'parent_id');
      }])->select('name', 'id', 'parent_id')->get();

      return $categories;
    }

    public function getOrAddManufacturer($name)
    {
      $manufacturer = ProductManufacturer::firstOrCreate(['name' => $name]);

      return $manufacturer->id;
    }

    public function validateProduct()
    {
      $attributes = request()->validate([
        'type' => ['required', 'size:1'],
        'name' => ['required', 'min:3', 'max:255', 'string'],
        'description' => ['min:3', 'string', 'nullable'],
        'product_key' => ['required', 'unique:products', 'string'],
        'part_number' => ['string', 'nullable'],
        'por_id' => ['integer', 'unique:products', 'nullable'],
        'header' => ['string', 'nullable'],
        'quantity' => ['numeric', 'nullable'],
        'slug' => ['string', 'unique:products', 'nullable'],
        'manufacturer' => ['string', 'nullable'],
        'model' => ['string', 'nullable'],
        'inactive' => ['boolean'],
        'hide_on_website' => ['boolean']
      ]);

      return $attributes;

    }

    public function validateRates()
    {
      $rates = request()->validate([
        'rates.*.time' => ['numeric', 'required_with:rates.*.rate', 'nullable'],
        'rates.*.period' => ['required_with:rates.*.time', 'numeric'],
        'rates.*.rate' => ['numeric', 'required_with:rates.*.time', 'nullable'],
      ]);

      return $rates;
    }


}
