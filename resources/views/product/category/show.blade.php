@extends('layouts.card')

@section('title', $category->name)

@section('heading')
  <div class="d-flex justify-content-between align-items-center">
    <span>{{ $category->name }}</span>

    @if ($loggedIn)
      <a href="/product/category/{{ $category->id }}/edit" class="btn btn-primary btn-sm">EDIT</a>
    @endif
  </div>
@endsection

@section('card-content')

  @include('partials.errors')

  <div class="row">
      <span>{{ $category->description }}</span>
  </div>

@endsection
