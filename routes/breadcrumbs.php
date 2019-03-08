<?php

// Home
Breadcrumbs::for('home', function ($trail) {
  $trail->push('Home', "/");
});

Breadcrumbs::for('categories', function ($trail) {
  $trail->parent('home');
  $trail->push('Categories', route('category.index'));
});

// categories
Breadcrumbs::for('category', function ($trail, $category) {
  if ($category->parent)
    $trail->parent('category', $category->parent);
  else
    $trail->parent('categories');

  $trail->push($category->name, route('category.show', $category->slug));
});

?>
