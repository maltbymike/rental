@extends('layouts.card')

@section('title', 'Administration Panel')

@section('heading', 'Administration Dashboard')

@section('card-content')

  @include('partials.errors')

  <div class="card">
      <div class="card-header">Inventory Tools</div>
      <div class="card-body">
        <div class="row">

          <div class="text-center col-sm-3">
            <a href="/product/category/">
              <img src="{{ asset('img/icons/Tools.png') }}">
              <div>Product Categories</div>
            </a>
          </div>

          <div class="text-center col-sm-3">
            <a href="/product/category/create">
              <img src="{{ asset('img/icons/add.png') }}">
              <div>Add New Product Categories</div>
            </a>
          </div>

        </div>
      </div>
  </div>

@endsection
