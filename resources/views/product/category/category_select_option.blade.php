<?php
  $prefix = str_repeat("&#160;&#160;&#160;", $category_level);

  if (isset($product))
    $selected = collect(old("categories", $product->categories->pluck('id')))->contains($category_for_select->id) ? "selected" : "";
  elseif (isset($category))
    $selected = old("categories", $category->parent_id) == $category_for_select->id ? "selected" : "";
  else
    $selected = "";
?>

<option value="{{ $category_for_select->id }}" {{ $selected }}>{!! $prefix !!}{{ $category_for_select->name }}</option>
<?php $category_level++; ?>
@foreach ($category_for_select->children as $category_for_select)
  @include('product.category.category_select_option')
@endforeach
<?php $category_level--; ?>
