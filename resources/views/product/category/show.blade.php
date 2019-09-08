@extends('layouts.card')

@section('title', $category->name)


@section('heading')

<div class="d-flex justify-content-between align-items-center">
  <span>{{ $category->name }}</span>

  @if (Auth::check())
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

  <div class="row">
    @foreach($subcategories as $subcategory)
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4 mt-4">
      <a href="/product/category/{{ $subcategory->slug }}">
        <div class="card">
          <div class='card-header'>{{ $subcategory->name }}</div>
          @if($subcategory->getFirstMediaUrl('category_images'))
          <img class="category-thumb card-img-top" src="{{ $subcategory->getFirstMediaUrl('category_images', 'thumb') }}" />
          @else
          <img class="category-thumb card-img-top" src="https://via.placeholder.com/350x200" />
          @endif
        </div>
      </a>
    </div>
    @endforeach
  </div>

  <table class="table table-striped">
    <thead>
      <tr>
        <th colspan="4" class="table-dark">Rental Equipment</th>
        <th colspan="2" class="text-center table-dark d-none d-md-table-cell">Weekend</th>
      </tr>
      <tr>
        <th scope="col" class="table-dark" style="width:40%"></th>
        <th scope="col" class="text-center table-dark d-none d-sm-table-cell" style="width:12%">4 Hours</th>
        <th scope="col" class="text-center table-dark" style="width:12%">Daily</th>
        <th scope="col" class="text-center table-dark d-none d-sm-table-cell" style="width:12%">Weekly</th>
        <th scope="col" class="text-center table-dark d-none d-md-table-cell" style="width:12%; border-top:0">Out Friday after 4pm</th>
        <th scope="col" class="text-center table-dark d-none d-md-table-cell" style="width:12%; border-top:0">Out Saturday</th>
        @if (Auth::check())
          <td></td>
        @endif
      </tr>
    </thead>
    <tbody>
      @foreach($products as $product)
      @if ($product->inactive) <tr class="table-danger">
      @else <tr>
      @endif
        <th scope="row"><a href="/product/{{ $product->slug }}">{{ $product->name }}</a></th>
        <td class="text-center d-none d-sm-table-cell">{{ $product->rates->firstWhere('hours', ">=", env('4_HOURS')) ? $product->rates->firstWhere('hours', ">=", env('4_HOURS'))->rate : "---" }}</td>
        <td class="text-center table-dark">{{ $product->rates->firstWhere('hours', ">=", env('DAY_HOURS')) ? $product->rates->firstWhere('hours', ">=", env('DAY_HOURS'))->rate : "---" }}</td>
        <td class="text-center d-none d-sm-table-cell">{{ $product->rates->firstWhere('hours', ">=", env('WEEK_HOURS')) ? $product->rates->firstWhere('hours', ">=", env('WEEK_HOURS'))->rate : "---" }}</td>
        <td class="text-center d-none d-md-table-cell">
          @if ($product->rates->where('hours', env('DAY_HOURS'))->first())
            {{ number_format($product->rates->where('hours', env('DAY_HOURS'))->first()->rate * 1.5, 2) }}
          @elseif ($product->rates->firstWhere('hours', ">=", env('WEEK_HOURS')))
            {{ $product->rates->firstWhere('hours', ">=", env('WEEK_HOURS'))->rate }}
          @else
            ---
          @endif
        </td>
        <td class="text-center d-none d-md-table-cell">{{ $product->rates->firstWhere('hours', ">=", env('DAY_HOURS')) ? $product->rates->firstWhere('hours', ">=", env('DAY_HOURS'))->rate : "---" }}</td>
        @if (Auth::check())
          <td><a href="/product/{{ $product->slug }}/edit" class="btn btn-primary btn-sm">EDIT</a></td>
        @endif
      </tr>
      @endforeach
    </tbody>
  </table>

@endsection
