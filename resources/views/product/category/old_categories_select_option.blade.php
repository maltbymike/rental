<option value="{{ $categories_single->id }}" {{ old('parent_id', $category->parent_id) == $categories_single->id ? "selected" : "" }}>
  <?php echo str_repeat('&nbsp;&nbsp;', $level); ?>{{ $categories_single->name }}
</option>

@if ($categories_single->activeChildren()->count() > 0)
    <?php $level++ ?>
    @foreach($categories_single->activeChildren as $categories_single)
      @include('product.category.categories_select_option', [
        'categories_single' => $categories_single,
        'level' => $level,
        'category' => $category
      ])
   @endforeach
@endif
