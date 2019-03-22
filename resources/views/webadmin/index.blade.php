@extends('layouts.card')

@section('title', 'Administration Panel')

@section('heading', 'Administration Dashboard')

@section('card-content')

  @include('partials.errors')

  <div class="card">
      <div class="card-header">Inventory Tools</div>
      <div class="card-body">
        <div class="row">

          <div class="text-center col-xl-2 col-sm-3 col-6 mb-4">
            <a href="/product/category">
              <i class="fas fa-list fa-6x"></i>
              <div>View Products</div>
            </a>
          </div>

          <div class="text-center col-xl-2 col-sm-3 col-6 mb-4">
            <a href="/product/create/">
              <i class="fas fa-plus-circle fa-6x"></i>
              <div>Add New Product</div>
            </a>
          </div>

          <div class="text-center col-xl-2 col-sm-3 col-6 mb-4">
            <a href="/product/category/create">
              <i class="fas fa-folder-plus fa-6x"></i>
              <div>Add New Product Categories</div>
            </a>
          </div>

        </div>
      </div>
  </div>

@endsection
