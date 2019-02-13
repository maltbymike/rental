@extends('layouts.card')

@section('title', 'Create Product Category')

@section('heading', 'Create Product Category')

@section('card-content')

  @include('partials.errors')

  <form method="post" action="/product">

    @CSRF

    <div class="form-group row">
      <label for="name" class="col-sm-2 form-control-label {{ $errors->has('name') ? 'text-danger' : '' }}">Product Name:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" id="name" name="name" value="{{ old('name') }}" required>
      </div>
    </div>

    <div class="form-group row">
      <label for="description" class="col-sm-2 form-control-label {{ $errors->has('description') ? 'text-danger' : '' }}">Description:</label>
      <div class="col-sm-10">
        <textarea name="description" id="description" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}">{{ old('description') }}</textarea>
      </div>
    </div>

    <div class="form-group row">
      <label for="part_number" class="col-sm-2 form-control-label {{ $errors->has('part_number') ? 'text-danger' : '' }}">Product Number:</label>
      <div class="col-sm-4">
        <input type="text" class="form-control {{ $errors->has('part_number') ? 'is-invalid' : '' }}" id="part_number" name="part_number" value="{{ old('part_number') }}">
      </div>
    </div>

    <div class="form-group row">
      <label for="por_num" class="col-sm-2 form-control-label {{ $errors->has('por_num') ? 'text-danger' : '' }}">POR Product Number:</label>
      <div class="col-sm-4">
        <input type="text" class="form-control {{ $errors->has('por_num') ? 'is-invalid' : '' }}" id="por_num" name="por_num" value="{{ old('por_num') }}">
      </div>
    </div>

    <div class="form-group row">
      <label for="header" class="col-sm-2 form-control-label {{ $errors->has('header') ? 'text-danger' : '' }}">Header:</label>
      <div class="col-sm-4">
        <input type="text" class="form-control {{ $errors->has('header') ? 'is-invalid' : '' }}" id="header" name="header" value="{{ old('header') }}">
      </div>
    </div>

    <div class="form-group row">
      <label for="quantity" class="col-sm-2 form-control-label {{ $errors->has('quantity') ? 'text-danger' : '' }}">Quantity:</label>
      <div class="col-sm-2">
        <input type="text" class="form-control {{ $errors->has('quantity') ? 'is-invalid' : '' }}" id="quantity" name="quantity" value="{{ old('quantity') }}">
      </div>
    </div>

    <div class="form-group row">
      <div class="col-sm-2 form-control-label">
        Rates:
      </div>
      <div class="col-sm-2">
        <div class="text-center">
          <label for="2_hour" class="form-control-label {{ $errors->has('2_hour') ? 'text-danger' : '' }}">2 Hour:</label>
        </div>
        <input type="text" class="form-control {{ $errors->has('2_hour') ? 'is-invalid' : '' }}" id="2_hour" name="2_hour" value="{{ old('2_hour') }}">
      </div>
      <div class="col-sm-2">
        <div class="text-center">
          <label for="4_hour" class="form-control-label {{ $errors->has('4_hour') ? 'text-danger' : '' }}">4 Hour:</label>
        </div>
        <input type="text" class="form-control {{ $errors->has('4_hour') ? 'is-invalid' : '' }}" id="4_hour" name="4_hour" value="{{ old('4_hour') }}">
      </div>
      <div class="col-sm-2">
        <div class="text-center">
          <label for="daily" class="form-control-label {{ $errors->has('daily') ? 'text-danger' : '' }}">Daily:</label>
        </div>
        <input type="text" class="form-control {{ $errors->has('daily') ? 'is-invalid' : '' }}" id="daily" name="daily" value="{{ old('daily') }}">
      </div>
      <div class="col-sm-2">
        <div class="text-center">
          <label for="weekly" class="form-control-label {{ $errors->has('weekly') ? 'text-danger' : '' }}">Weekly:</label>
        </div>
        <input type="text" class="form-control {{ $errors->has('weekly') ? 'is-invalid' : '' }}" id="weekly" name="weekly" value="{{ old('weekly') }}">
      </div>
      <div class="col-sm-2">
        <div class="text-center">
          <label for="4_week" class="form-control-label {{ $errors->has('4_week') ? 'text-danger' : '' }}">4 Week:</label>
        </div>
        <input type="text" class="form-control {{ $errors->has('4_week') ? 'is-invalid' : '' }}" id="4_week" name="4_week" value="{{ old('4_week') }}">
      </div>
    </div>

    <div class="form-group row">
      <label for="categories" class="col-sm-2 form-control-label {{ $errors->has('categories') ? 'text-danger' : '' }}">Categories:</label>
      <div class="col-sm-10">
        <select multiple class="form-control {{ $errors->has('categories') ? 'is-invalid' : '' }}" id="categories" name="categories" size="10">
          @foreach ($categories as $id => $name)
            <option value="{{ $id }}" {{ old("categories") == $id ? "selected" : "" }}>{{ $name }}</option>
          @endforeach
        </select>
      </div>
    </div>

    <div class="form-group row">
      <label for="slug" class="col-sm-2 form-control-label {{ $errors->has('slug') ? 'text-danger' : '' }}">Product Slug:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control {{ $errors->has('slug') ? 'is-invalid' : '' }}" name="slug" id="slug" value="{{ old('slug') }}">
      </div>
    </div>

    <div class="form-group row">
      <label for="manufacturer" class="col-sm-2 form-control-label {{ $errors->has('manufacturer') ? 'text-danger' : '' }}">Manufacturer:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control {{ $errors->has('manufacturer') ? 'is-invalid' : '' }}" name="manufacturer" id="manufacturer" value="{{ old('manufacturer') }}">
      </div>
    </div>

    <div class="form-group row">
      <label for="model" class="col-sm-2 form-control-label {{ $errors->has('model') ? 'text-danger' : '' }}">Model:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control {{ $errors->has('model') ? 'is-invalid' : '' }}" name="model" id="model" value="{{ old('model') }}">
      </div>
    </div>

    <div class="form-group row">
      <label for="inactive" class="col-sm-2 form-check-label {{ $errors->has('inactive') ? 'text-danger' : '' }}">Product is Inactive:</label>
      <div class="col-sm-10">
        <div class="form-check">
          <input type="hidden" name="inactive" id="inactiveHidden" value="0" />
          <input type="checkbox" class="form-check-input" name="inactive" id="inactive" {{ old("inactive") == TRUE ? "checked" : "" }} />
        </div>
      </div>
    </div>

    <div class="form-group row">
      <label for="hide_on_website" class="col-sm-2 form-check-label {{ $errors->has('hide_on_website') ? 'text-danger' : '' }}">Hide on Website:</label>
      <div class="col-sm-10">
        <div class="form-check">
          <input type="hidden" name="hide_on_website" id="hide_on_websiteHidden" value="0" />
          <input type="checkbox" class="form-check-input" name="hide_on_website" id="hide_on_website" {{ old("hide_on_website") == TRUE ? "checked" : "" }} />
        </div>
      </div>
    </div>

    <input type="submit" class="btn btn-primary btn-lg btn-block" value="Create Product" />

  </form>
@endsection
