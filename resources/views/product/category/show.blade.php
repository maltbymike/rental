@extends('layouts.card')

@section('title', $category->name)


@section('heading')

<div class="d-flex justify-content-between align-items-center">
  <span>{{ $category->name }}</span>

  @if ($loggedIn)
    <a href="/product/category/{{ $category->slug }}/edit" class="btn btn-primary btn-sm">EDIT</a>
  @endif
</div>

@endsection


@section('breadcrumbs', Breadcrumbs::render('category', $category))


@section('card-content')

  @include('partials.errors')

  <div class="row">
      <span>{{ $category->description }}</span>
  </div>

  <table class="table table-hover">
    <thead class="thead-light">
      <tr>
        <th scope="col" style="width:40%"></th>
        <th scope="col" class="text-center" style="width:12%">4 Hours</th>
        <th scope="col" class="text-center" style="width:12%">Daily</th>
        <th scope="col" class="text-center" style="width:12%">Weekly</th>
        <th scope="col" class="text-center" style="width:12%">Friday after 4pm to Monday by 9am</th>
        <th scope="col" class="text-center" style="width:12%">Saturday to Monday by 9am</th>
      </tr>
    </thead>
    <tbody>
      @foreach($products as $product)
      <tr>
        <th scope="row">{{ $product->name }}</th>
        <td class="text-center">4 Hours</td>
        <td class="text-center">24 Hours</td>
        <td class="text-center">1 Week</td>
        <td class="text-center">Friday</td>
        <td class="text-center">Saturday</td>
      </tr>
      @endforeach
    </tbody>
  </table>

  <div class="row">
    @foreach($subcategories as $subcategory)
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4 mt-4">
      <a href="/product/category/{{ $subcategory->slug }}">
        <div class="card">
          <div class='card-header'>{{ $subcategory->name }}</div>
          <img class="card-img-top" src="https://via.placeholder.com/350x200" />

        </div>
      </a>
    </div>
    @endforeach
  </div>

@endsection
