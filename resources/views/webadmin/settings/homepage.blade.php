@extends('layouts.card')

@section('title', 'Homepage Settings')

@section('heading', 'Homepage Settings')

@section('breadcrumbs', Breadcrumbs::render('image-create', 'header'))

@section('card-content')

  @include('partials.errors')

  <form method="post" action="/settings/homepage/" enctype="multipart/form-data">

    @CSRF
    @METHOD('patch')

    <div class="card">
      <div class="card-header">Homepage Slider Images</div>
      <div class="card-body">

        <div class="form-group row">
          <label for="image" class="col-sm-2 form-control-label {{ $errors->has('image') ? 'text-danger' : '' }}">Header Slider Image: (Image should be 1900x1080)</label>
          <div class="col-lg-4 col-md-6 col-sm-8">
            <input type="file" class="form-control {{ $errors->has('image') ? 'is-invalid' : '' }}" id="image" name="image" />
          </div>
        </div>

        <div class="form-group row">
          <label for="title" class="col-sm-2 form-control-label {{ $errors->has('title') ? 'text-danger' : '' }}">Title</label>
          <div class="col-sm-10">
            <input type="text" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" id="title" name="title" value="{{ old('title') }}">
          </div>
        </div>

        <div class="form-group row">
          <label for="caption" class="col-sm-2 form-control-label {{ $errors->has('caption') ? 'text-danger' : '' }}">Caption Text</label>
          <div class="col-sm-10">
            <input type="text" class="form-control {{ $errors->has('caption') ? 'is-invalid' : '' }}" id="caption" name="caption" value="{{ old('caption') }}">
          </div>
        </div>

        <div class="form-group row">
          <label for="button_text" class="col-sm-2 form-control-label {{ $errors->has('button_text') ? 'text-danger' : '' }}">Button Text</label>
          <div class="col-lg-4 col-md-6 col-sm-8">
            <input type="text" class="form-control {{ $errors->has('button_text') ? 'is-invalid' : '' }}" id="button_text" name="button_text" value="{{ old('button_text') }}">
          </div>
        </div>

        <div class="form-group row">
          <label for="link_to" class="col-sm-2 form-control-label {{ $errors->has('link_to') ? 'text-danger' : '' }}">Link To</label>
          <div class="col-sm-10">
            <input type="text" class="form-control {{ $errors->has('link_to') ? 'is-invalid' : '' }}" id="link_to" name="link_to" value="{{ old('link_to') }}">
          </div>
        </div>

        <div class="form-group row">
          <label for="inactive" class="col-sm-2 form-check-label {{ $errors->has('inactive') ? 'text-danger' : '' }}">Mark Inactive:</label>
          <div class="col-sm-10">
            <div class="form-check">
              <input type="hidden" name="inactive" id="inactiveHidden" value="0" />
              <input type="checkbox" class="form-check-input" name="inactive" id="inactive" {{ old("inactive") == TRUE ? "checked" : "" }} />
            </div>
          </div>
        </div>

        <h5>Current Images</h5>
        <div class="row">
          @foreach($images as $image)
          <div class="card col-md-3 col-sm-4 col-6">
            <img class="card-img-top" src="{{ asset('/storage/images/' . $image->filename) }}" />
            <div class="card-body">
              <h5 class="card-title">{{ $image->title }}</h5>
              <p class="card-text">{{ $image->caption }}</p>
              <a href="{{ $image->link_to }}" class="btn btn-primary">{{ $image->button_text }}</a>
            </div>
          </div>
          @endforeach
        </div>

      </div>
    </div>

    <input type="submit" class="btn btn-primary btn-lg btn-block" value="Add Image(s)" />

  </form>



@endsection
