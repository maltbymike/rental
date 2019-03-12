@extends('layouts.card')

@section('title', $product->name)


@section('heading')

<div class="d-flex justify-content-between align-items-center">
  <span>{{ $product->name }}</span>

  @if ($loggedIn)
    <a href="/product/{{ $product->slug }}/edit" class="btn btn-primary btn-sm">EDIT</a>
  @endif
</div>

@endsection


@section('breadcrumbs', Breadcrumbs::render('product', $product))

@section('card-content')

  @include('partials.errors')

  <div class="row">

    <div class="col-sm-6 col-lg-4 mb-4">
      <div class="card">
        <img class="card-img-top" src="https://via.placeholder.com/350x400" alt="Image of {{ $product->name }}" />
      </div>
    </div>

    <div class="col-sm-6 col-lg-3 order-lg-12 mb-4">
      <table class="table table-hover">
        <thead class="thead-dark">
          <tr>
            <th scope="rowgroup" colspan="2">Rental Rates</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row" style="width: 50%">4 Hours</th>
            <td class="text-right" style="width: 50%">{{ $product->rates->firstWhere('hours', ">=", env('4_HOURS')) ? $product->rates->firstWhere('hours', ">=", env('4_HOURS'))->rate : "---" }}</td>
          </tr>
          <tr>
            <th scope="row">Daily</td>
            <td class="text-right">{{ $product->rates->firstWhere('hours', ">=", env('DAY_HOURS')) ? $product->rates->firstWhere('hours', ">=", env('DAY_HOURS'))->rate : "---" }}</td>
          </tr>
          <tr>
            <th scope="row">Weekly</td>
            <td class="text-right">{{ $product->rates->firstWhere('hours', ">=", env('WEEK_HOURS')) ? $product->rates->firstWhere('hours', ">=", env('WEEK_HOURS'))->rate : "---" }}</td>
          </tr>
        </tbody>
        <thead class="thead-light">
          <tr>
            <th scope="rowgroup" colspan="2">Weekend Rates</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row">Out Friday after 4pm</td>
            <td class="text-right">
              @if ($product->rates->where('hours', env('DAY_HOURS'))->first())
              {{ number_format($product->rates->where('hours', env('DAY_HOURS'))->first()->rate * 1.5, 2) }}
              @elseif ($product->rates->firstWhere('hours', ">=", env('WEEK_HOURS')))
              {{ $product->rates->firstWhere('hours', ">=", env('WEEK_HOURS'))->rate }}
              @else
              ---
              @endif
            </td>
          </tr>
          <tr>
            <th scope="row">Out Saturday</td>
            <td class="text-right">{{ $product->rates->firstWhere('hours', ">=", env('DAY_HOURS')) ? $product->rates->firstWhere('hours', ">=", env('DAY_HOURS'))->rate : "---" }}</td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="col-12 col-lg-5 mb-4">
      <h4>{{ $product->name }}</h4>
      <p>{{ $product->description }}</p>

      @if ($product->part_number)
      <dl class="row">
        <dt class="col-sm-4">Product Number</dt>
        <dd class="col-sm-8">{{ $product->part_number }}</dd>
      </dl>
      @endif

      @if ($product->manufacturer)
      <dl class="row">
        <dt class="col-sm-4">Manufacturer</dt>
        <dd class="col-sm-8">{{ $product->manufacturer->name }}</dd>
      </dl>
      @endif

      @if ($product->model)
      <dl class="row">
        <dt class="col-sm-4">Model</dt>
        <dd class="col-sm-8">{{ $product->model }}</dd>
      </dl>
      @endif

    </div>


  </div>

  @endsection
