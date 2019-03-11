@extends('layouts.app')

@section('content')

  @yield('breadcrumbs')

  <div class="row justify-content-center">
      <div class="col-md-12">
          <div class="card">
              <div class="card-header text-white bg-dark">@yield('heading')</div>

              <div class="card-body">
                  @if (session('status'))
                      <div class="alert alert-success" role="alert">
                          {{ session('status') }}
                      </div>
                  @endif

                  @yield('card-content')
              </div>
          </div>
      </div>
  </div>

@endsection
