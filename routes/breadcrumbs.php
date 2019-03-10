<?php

// Home
Breadcrumbs::for('home', function ($trail) {
  $trail->push('Home', "/");
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

// Products
Breadcrumbs::for('products', function ($trail) {
  $trail->parent('home');
  $trail->push('Products', route('product.index'));
});

Breadcrumbs::for('product', function ($trail, $product) {
  $trail->parent('products');
  $trail->push($product->name, route('product.show', $product->slug));
});

?>
