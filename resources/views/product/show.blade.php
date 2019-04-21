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

    <!-- Begin Image Card -->
    <div class="col-md-6 mb-4">
    <!-- <div class="col-sm-6 col-lg-4 mb-4"> -->
      <div class="card">
        <div id="productImageCarousel" class="carousel slide" data-ride="carousel">
          <ol class="carousel-indicators">
            @for ($i = 0; $i < count($images); $i++)
              <li data-target="#productImageCarousel" data-slide-to="{{ $i }}" class="{{ $i == 0 ? 'active' : '' }}"></li>
            @endfor
          </ol>
          <div class="carousel-inner">
            <?php $i = 0; ?>
            @if (count($images))
              @foreach($images as $image)
                @if ($i == 0)
                  <div class="carousel-item active">
                @else
                  <div class="carousel-item">
                @endif
                    <img class="h-100 d-block mx-auto" src="{{ asset('/storage/images/' . $image->filename) }}" alt="Image of {{ $product->name }}" />
                  </div>
                <?php $i++; ?>
              @endforeach
            @else
              <div class="carousel-item active">
                <img class="h-100 d-block mx-auto" src="https://via.placeholder.com/1200x1200?text=Image+Coming+Soon" />
              </div>
            @endif
          </div>
          <a class="carousel-control-prev" href="#productImageCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#productImageCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>

      </div>
    </div>
    <!-- End Image Card -->

    <div class="col-md-6 mb-4">

      <!-- Begin Rates Table -->
      <div class="row mb-4 align-items-end" style="font-size: larger">
        <h4 class="col-12 col-lg-7 p-3 mt-lg-0 mt-2 mb-0 bg-dark text-light">Rental Rates:</h4>

        <p class="order-lg-1 col-7 col-lg d-lg-block d-inline text-lg-center mb-0 p-2 align-bottom">4 Hours</p>
        <p class="btn btn-lg btn-primary order-lg-3 col-5 col-lg mx-lg-1 my-1">{{ $product->rates->firstWhere('hours', ">=", env('4_HOURS')) ? $product->rates->firstWhere('hours', ">=", env('4_HOURS'))->rate : "---" }}</p>

        <p class="order-lg-1 col-7 col-lg d-lg-block d-inline text-lg-center mb-0 p-2">Daily</p>
        <p class="btn btn-lg btn-primary order-lg-3 col-5 col-lg mx-lg-1 my-1">{{ $product->rates->firstWhere('hours', ">=", env('DAY_HOURS')) ? $product->rates->firstWhere('hours', ">=", env('DAY_HOURS'))->rate : "---" }}</p>

        <p class="order-lg-1 col-7 col-lg d-lg-block d-inline text-lg-center mb-0 p-2">Weekly</p>
        <p class="btn btn-lg btn-primary order-lg-3 col-5 col-lg mx-lg-1 my-1">{{ $product->rates->firstWhere('hours', ">=", env('WEEK_HOURS')) ? $product->rates->firstWhere('hours', ">=", env('WEEK_HOURS'))->rate : "---" }}</p>

        <h4 class="col-12 col-lg-5 mt-lg-0 mt-2 mb-0 p-3 bg-secondary text-lg-center text-light">Weekend Rates</h5>

        <p class="order-lg-1 col-7 col-lg d-lg-block d-inline text-lg-center mb-0 p-2">Out Friday After 4pm</p>
        <p class="btn btn-lg btn-primary order-lg-3 col-5 col-lg mx-lg-1 my-1">
            @if ($product->rates->where('hours', env('DAY_HOURS'))->first())
              {{ number_format($product->rates->where('hours', env('DAY_HOURS'))->first()->rate * 1.5, 2) }}
            @elseif ($product->rates->firstWhere('hours', ">=", env('WEEK_HOURS')))
              {{ $product->rates->firstWhere('hours', ">=", env('WEEK_HOURS'))->rate }}
            @else
              ---
            @endif
        </p>

        <p class="order-lg-1 col-7 col-lg d-lg-block d-inline text-lg-center mb-0 p-2">Out Saturday</p>
        <p class="btn btn-lg btn-primary order-lg-3 col-5 col-lg mx-lg-1 my-1">{{ $product->rates->firstWhere('hours', ">=", env('DAY_HOURS')) ? $product->rates->firstWhere('hours', ">=", env('DAY_HOURS'))->rate : "---" }}</p>

        <div class="order-lg-2 col-12 bg-dark"></div>

      </div>
      <!-- End Rates Table -->

      <!-- Begin Product Content Section -->
      <div class="row">
        <h4 class="col-12 p-3 bg-dark text-light">{{ $product->name }}</h4>
        <p class="col-12">{{ $product->description }}</p>

        @if ($product->part_number)
          <p class="col-4 font-weight-bold">Product Number</p>
          <p class="col-8">{{ $product->part_number }}</p>
        @endif

        @if ($product->manufacturer)
          <p class="col-sm-4 font-weight-bold">Manufacturer</p>
          <p class="col-sm-8">{{ $product->manufacturer->name }}</p>
        @endif

        @if ($product->model)
          <p class="col-sm-4 font-weight-bold">Model</p>
          <p class="col-sm-8">{{ $product->model }}</p>
        @endif

      </div>
      <!-- End Product Content Section  -->

    </div>

  </div>

  @endsection
