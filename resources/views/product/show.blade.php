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
      <span>{{ $product->description }}</span>
  </div>

  <div class="row">

    <div class="col-sm-6 col-lg-4">
      <div class="card">
        <img class="card-img-top" src="https://via.placeholder.com/350x400" alt="Image of {{ $product->name }}" />
      </div>
    </div>

    <div class="col-sm-6 col-lg-3 order-lg-12">
      <table class="table">
        <thead class="thead-dark">
          <tr>
            <th scope="rowgroup" colspan="2">Rental Rates</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row" class="col-6">4 Hours</th>
            <td class="col-6">{{ $product->rates->firstWhere('hours', ">=", env('4_HOURS')) ? $product->rates->firstWhere('hours', ">=", env('4_HOURS'))->rate : "---" }}</td>
          </tr>
          <tr>
            <th scope="row">Daily</td>
            <td>{{ $product->rates->firstWhere('hours', ">=", env('DAY_HOURS')) ? $product->rates->firstWhere('hours', ">=", env('DAY_HOURS'))->rate : "---" }}</td>
          </tr>
          <tr>
            <th scope="row">Weekly</td>
            <td>{{ $product->rates->firstWhere('hours', ">=", env('WEEK_HOURS')) ? $product->rates->firstWhere('hours', ">=", env('WEEK_HOURS'))->rate : "---" }}</td>
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
            <td>
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
            <td>{{ $product->rates->firstWhere('hours', ">=", env('DAY_HOURS')) ? $product->rates->firstWhere('hours', ">=", env('DAY_HOURS'))->rate : "---" }}</td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="col-12 col-lg-5">
      as;dlkfnasd;flkansd;lknas;lgnajkgbakjlsbgklajsbkjasbdfkjabsdfkjba;sdfna;lsndfla;ksndflanksd;fl
      as;dlkfnasd;flkansd;lknas;lgnajkgbakjlsbgklajsbkjasbdfkjabsdfkjba;sdfna;lsndfla;ksndflanksd;fl
      as;dlkfnasd;flkansd;lknas;lgnajkgbakjlsbgklajsbkjasbdfkjabsdfkjba;sdfna;lsndfla;ksndflanksd;fl
      as;dlkfnasd;flkansd;lknas;lgnajkgbakjlsbgklajsbkjasbdfkjabsdfkjba;sdfna;lsndfla;ksndflanksd;fl
      as;dlkfnasd;flkansd;lknas;lgnajkgbakjlsbgklajsbkjasbdfkjabsdfkjba;sdfna;lsndfla;ksndflanksd;fl
      as;dlkfnasd;flkansd;lknas;lgnajkgbakjlsbgklajsbkjasbdfkjabsdfkjba;sdfna;lsndfla;ksndflanksd;fl
      as;dlkfnasd;flkansd;lknas;lgnajkgbakjlsbgklajsbkjasbdfkjabsdfkjba;sdfna;lsndfla;ksndflanksd;fl
      as;dlkfnasd;flkansd;lknas;lgnajkgbakjlsbgklajsbkjasbdfkjabsdfkjba;sdfna;lsndfla;ksndflanksd;fl
      as;dlkfnasd;flkansd;lknas;lgnajkgbakjlsbgklajsbkjasbdfkjabsdfkjba;sdfna;lsndfla;ksndflanksd;fl
      as;dlkfnasd;flkansd;lknas;lgnajkgbakjlsbgklajsbkjasbdfkjabsdfkjba;sdfna;lsndfla;ksndflanksd;fl
      as;dlkfnasd;flkansd;lknas;lgnajkgbakjlsbgklajsbkjasbdfkjabsdfkjba;sdfna;lsndfla;ksndflanksd;fl
      as;dlkfnasd;flkansd;lknas;lgnajkgbakjlsbgklajsbkjasbdfkjabsdfkjba;sdfna;lsndfla;ksndflanksd;fl
      as;dlkfnasd;flkansd;lknas;lgnajkgbakjlsbgklajsbkjasbdfkjabsdfkjba;sdfna;lsndfla;ksndflanksd;fl
      as;dlkfnasd;flkansd;lknas;lgnajkgbakjlsbgklajsbkjasbdfkjabsdfkjba;sdfna;lsndfla;ksndflanksd;fl
      as;dlkfnasd;flkansd;lknas;lgnajkgbakjlsbgklajsbkjasbdfkjabsdfkjba;sdfna;lsndfla;ksndflanksd;fl
      as;dlkfnasd;flkansd;lknas;lgnajkgbakjlsbgklajsbkjasbdfkjabsdfkjba;sdfna;lsndfla;ksndflanksd;fl
      as;dlkfnasd;flkansd;lknas;lgnajkgbakjlsbgklajsbkjasbdfkjabsdfkjba;sdfna;lsndfla;ksndflanksd;fl
      as;dlkfnasd;flkansd;lknas;lgnajkgbakjlsbgklajsbkjasbdfkjabsdfkjba;sdfna;lsndfla;ksndflanksd;fl
      as;dlkfnasd;flkansd;lknas;lgnajkgbakjlsbgklajsbkjasbdfkjabsdfkjba;sdfna;lsndfla;ksndflanksd;fl
      as;dlkfnasd;flkansd;lknas;lgnajkgbakjlsbgklajsbkjasbdfkjabsdfkjba;sdfna;lsndfla;ksndflanksd;fl
      as;dlkfnasd;flkansd;lknas;lgnajkgbakjlsbgklajsbkjasbdfkjabsdfkjba;sdfna;lsndfla;ksndflanksd;fl
      as;dlkfnasd;flkansd;lknas;lgnajkgbakjlsbgklajsbkjasbdfkjabsdfkjba;sdfna;lsndfla;ksndflanksd;fl
      as;dlkfnasd;flkansd;lknas;lgnajkgbakjlsbgklajsbkjasbdfkjabsdfkjba;sdfna;lsndfla;ksndflanksd;fl
      as;dlkfnasd;flkansd;lknas;lgnajkgbakjlsbgklajsbkjasbdfkjabsdfkjba;sdfna;lsndfla;ksndflanksd;fl
      as;dlkfnasd;flkansd;lknas;lgnajkgbakjlsbgklajsbkjasbdfkjabsdfkjba;sdfna;lsndfla;ksndflanksd;fl
      as;dlkfnasd;flkansd;lknas;lgnajkgbakjlsbgklajsbkjasbdfkjabsdfkjba;sdfna;lsndfla;ksndflanksd;fl
      as;dlkfnasd;flkansd;lknas;lgnajkgbakjlsbgklajsbkjasbdfkjabsdfkjba;sdfna;lsndfla;ksndflanksd;fl
      as;dlkfnasd;flkansd;lknas;lgnajkgbakjlsbgklajsbkjasbdfkjabsdfkjba;sdfna;lsndfla;ksndflanksd;fl
      as;dlkfnasd;flkansd;lknas;lgnajkgbakjlsbgklajsbkjasbdfkjabsdfkjba;sdfna;lsndfla;ksndflanksd;fl
      as;dlkfnasd;flkansd;lknas;lgnajkgbakjlsbgklajsbkjasbdfkjabsdfkjba;sdfna;lsndfla;ksndflanksd;fl
      as;dlkfnasd;flkansd;lknas;lgnajkgbakjlsbgklajsbkjasbdfkjabsdfkjba;sdfna;lsndfla;ksndflanksd;fl
      as;dlkfnasd;flkansd;lknas;lgnajkgbakjlsbgklajsbkjasbdfkjabsdfkjba;sdfna;lsndfla;ksndflanksd;fl
      as;dlkfnasd;flkansd;lknas;lgnajkgbakjlsbgklajsbkjasbdfkjabsdfkjba;sdfna;lsndfla;ksndflanksd;fl
      as;dlkfnasd;flkansd;lknas;lgnajkgbakjlsbgklajsbkjasbdfkjabsdfkjba;sdfna;lsndfla;ksndflanksd;fl
      as;dlkfnasd;flkansd;lknas;lgnajkgbakjlsbgklajsbkjasbdfkjabsdfkjba;sdfna;lsndfla;ksndflanksd;fl
      as;dlkfnasd;flkansd;lknas;lgnajkgbakjlsbgklajsbkjasbdfkjabsdfkjba;sdfna;lsndfla;ksndflanksd;fl
    </div>

  </div>

  @endsection
