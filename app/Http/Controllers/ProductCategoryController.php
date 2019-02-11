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
        $categories = ProductCategory::pluck('name', 'id');
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

        return view('product.category.show', compact('category', 'loggedIn'));
    }

    public function edit(ProductCategory $category)
    {
        $categories = ProductCategory::where('inactive', 0)->get();
        return view('product.category.edit', compact('categories', 'category'));
    }

    public function update(Request $request, ProductCategory $category)
    {
        $attributes = $this->validateCategory();
        $category->update($attributes);

        session()->flash('status', "Category: <b>{$attributes['name']}</b> was updated!");
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
        'inactive' => ['boolean']
      ]);

      $attributes['slug'] = $attributes['slug'] ?: str_slug($attributes['name']);

      return $attributes;
    }
}
