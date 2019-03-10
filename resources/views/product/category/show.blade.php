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

  <table class="table table-striped">
    <thead>
      <tr>
        <th colspan="4"></th>
        <th colspan="2" class="text-center table-dark pb-0 d-none d-md-table-cell" style="border-bottom:0">Weekend</th>
      </tr>
      <tr>
        <th scope="col" class="table-dark" style="width:40%"></th>
        <th scope="col" class="text-center table-dark d-none d-sm-table-cell" style="width:12%">4 Hours</th>
        <th scope="col" class="text-center table-dark" style="width:12%">Daily</th>
        <th scope="col" class="text-center table-dark d-none d-sm-table-cell" style="width:12%">Weekly</th>
        <th scope="col" class="text-center table-dark d-none d-md-table-cell" style="width:12%; border-top:0">Out Friday after 4pm</th>
        <th scope="col" class="text-center table-dark d-none d-md-table-cell" style="width:12%; border-top:0">Out Saturday</th>
      </tr>
    </thead>
    <tbody>
      @foreach($products as $product)
      <tr>
        <th scope="row">{{ $product->name }}</th>
        <td class="text-center d-none d-sm-table-cell">{{ $product->rates->firstWhere('hours', ">=", env('4_HOURS')) ? $product->rates->firstWhere('hours', ">=", env('4_HOURS'))->rate : "---" }}</td>
        <td class="text-center table-dark">{{ $product->rates->firstWhere('hours', ">=", env('DAY_HOURS')) ? $product->rates->firstWhere('hours', ">=", env('DAY_HOURS'))->rate : "---" }}</td>
        <td class="text-center d-none d-sm-table-cell">{{ $product->rates->firstWhere('hours', ">=", env('WEEK_HOURS')) ? $product->rates->firstWhere('hours', ">=", env('WEEK_HOURS'))->rate : "---" }}</td>
        <td class="text-center table-primary d-none d-md-table-cell">
          @if ($product->rates->where('hours', env('DAY_HOURS'))->first())
            {{ number_format($product->rates->where('hours', env('DAY_HOURS'))->first()->rate * 1.5, 2) }}
          @elseif ($product->rates->firstWhere('hours', ">=", env('WEEK_HOURS')))
            {{ $product->rates->firstWhere('hours', ">=", env('WEEK_HOURS'))->rate }}
          @else
            ---
          @endif
        </td>
        <td class="text-center table-primary d-none d-md-table-cell">{{ $product->rates->firstWhere('hours', ">=", env('DAY_HOURS')) ? $product->rates->firstWhere('hours', ">=", env('DAY_HOURS'))->rate : "---" }}</td>
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
