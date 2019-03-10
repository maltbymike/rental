@extends('layouts.card')

@section('title', 'Products')

@section('heading', 'Products')

@section('breadcrumbs', Breadcrumbs::render('products'))

@section('card-content')

  @include('partials.errors')

    @foreach ($products as $product)
      <div class="list-group list-group-flush">
        <div class="d-flex justify-content-between align-items-center">
          <a href="/product/{{ $product->slug }}" class="list-group-item list-group-item-action {{ $product->inactive ? 'list-group-item-danger' : 'list-group-item-light' }}">
            @if ($product->inactive)
              <del>{{ $product->name }}</del>
            @else
              {{ $product->name }}
            @endif
          </a>

          @if ($loggedIn)
            <a href="/product/{{ $product->slug }}/edit" class="btn btn-primary btn-sm">EDIT</a>
          @endif
        
        </div>
      </div>
    @endforeach

@endsection
