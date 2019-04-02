<?php

// Home
Breadcrumbs::for('home', function ($trail) {
  $trail->push('Home', "/");
});

// webadmin
Breadcrumbs::for('webadmin', function($trail) {
  $trail->push('Webadmin', '/webadmin');
});

// Categories
Breadcrumbs::for('categories', function ($trail) {
  $trail->parent('home');
  $trail->push('Categories', route('category.index'));
});

Breadcrumbs::for('category', function ($trail, $category) {
  if ($category->parent)
    $trail->parent('category', $category->parent);
  else
    $trail->parent('categories');

  $trail->push($category->name, route('category.show', $category->slug));
});

Breadcrumbs::for('category-edit', function ($trail, $category) {
  $trail->parent('category', $category);
  $trail->push('Edit', route('category.edit', $category->slug));
});

// Products
Breadcrumbs::for('products', function ($trail) {
  $trail->parent('home');
  $trail->push('Products', route('product.index'));
});

Breadcrumbs::for('product', function ($trail, $product) {
  $trail->parent('category', $product->categories->first());
  $trail->push($product->name, route('product.show', $product->slug));
});

Breadcrumbs::for('product-edit', function ($trail, $product) {
  $trail->parent('product', $product);
  $trail->push('Edit', route('product.edit', $product->slug));
});

Breadcrumbs::for('product-upload', function ($trail) {
  $trail->parent('webadmin');
  $trail->push('Upload', '/product/upload');
});

?>
