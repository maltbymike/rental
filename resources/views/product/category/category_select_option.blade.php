<?php $prefix = str_repeat("&#160;&#160;&#160;", $category_level); ?>
<option value="{{ $category->id }}" {{ old("categories") == $category->id ? "selected" : "" }}>{!! $prefix !!}{{ $category->name }}</option>
<?php $category_level++; ?>
@foreach ($category->children as $category)
  @include('product.category.category_select_option')
@endforeach
<?php $category_level--; ?>
