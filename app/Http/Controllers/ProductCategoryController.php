<?php

namespace App\Http\Controllers;

use App\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductCategoryController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth')->except(['index', 'show']);
    }

    public function index()
    {
        if ($loggedIn = Auth::check())
        {
          $categories = ProductCategory::all();
        }
        else
        {
          $categories = ProductCategory::where('inactive', 0)->get();
        }

        return view('product.category.index', compact('categories', 'loggedIn'));

    }

    public function create()
    {
        $categories = $this->getCategoryDataForSelectOption();

        return view('product.category.create', compact('categories'));
    }

    public function store()
    {
        $attributes = $this->validateCategory();
        $category = ProductCategory::create($attributes);

        session()->flash('status', "Category: <b>{$attributes['name']}</b> was created successfully!");
        return redirect('/product/category');
    }

    public function show(ProductCategory $category)
    {
        $loggedIn = Auth::check();

        $subcategories = $category->children()->with('products')->orderBy('name')->get();
        $products = $category->productsWithRates()->orderBy('name')->get();

        return view('product.category.show', compact('category', 'subcategories', 'products', 'loggedIn'));
    }

    public function edit(ProductCategory $category)
    {
        $categories = $this->getCategoryDataForSelectOption();

        return view('product.category.edit', compact('categories', 'category'));
    }

    public function update(Request $request, ProductCategory $category)
    {
        $attributes = $this->validateCategory();
        $category->update($attributes);

        session()->flash('status', "Category: {$attributes['name']} was updated!");
        return redirect('/product/category');
    }

    public function destroy(ProductCategory $category)
    {
        $category->delete();

        return redirect('/product/category');
    }

    public function validateCategory()
    {
      $attributes = request()->validate([
        'name' => ['required', 'min:3', 'max:255', 'string'],
        'description' => ['min:3', 'string', 'nullable'],
        'parent_id' => ['exists:product_categories,id', 'nullable'],
        'slug' => ['string', 'nullable'],
        'por_id' => ['integer', 'nullable'],
        'inactive' => ['boolean']
      ]);

      $attributes['slug'] = $attributes['slug'] ?: str_slug($attributes['name']);

      return $attributes;
    }

    public function getCategoryDataForSelectOption()
    {
      $categories = ProductCategory::where('parent_id', null)->with(['children' => function ($query) {
        $query->select('name', 'id', 'parent_id');
      }])->select('name', 'id', 'parent_id')->get();

      return $categories;
    }
}
