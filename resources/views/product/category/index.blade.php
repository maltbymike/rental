@extends('layouts.card')

@section('title', 'Product Categories')

@section('heading', 'Product Categories')

@section('card-content')

  @include('partials.errors')

    @foreach ($categories as $category)
      <div class="list-group list-group-flush">
        @if($category->parent_id == NULL)
          @include('product.category.categories')
        @endif
      </div>
    @endforeach

@endsection
