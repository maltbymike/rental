@extends('layouts.card')

@section('title', 'Create Product Category')

@section('heading', 'Create Product Category')

@section('card-content')

  @include('partials.errors')

  <form method="post" action="/product">

    @CSRF

    <div class="form-group row">
      <label for="type" class="col-sm-2 form-control-label {{ $errors->has('type') ? 'text-danger' : '' }}">Product Type:</label>
      <div class="col-sm-10">
        <select class="form-control col-3 {{ $errors->has('type') ? 'is-invalid' : '' }}" id="type" name="type">
          @foreach ($types as $type)
            <option value="{{ $type['type_code'] }}" {{ old("type", "T") == $type['type_code'] ? "selected" : "" }}>{{ $type['name'] }}</option>
          @endforeach
        </select>
      </div>
    </div>

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
      <label for="product_key" class="col-sm-2 form-control-label {{ $errors->has('product_key') ? 'text-danger' : '' }}">Product Key:</label>
      <div class="col-sm-4">
        <input type="text" class="form-control {{ $errors->has('product_key') ? 'is-invalid' : '' }}" id="product_key" name="product_key" value="{{ old('product_key') }}" required>
      </div>
    </div>

    <div class="form-group row">
      <label for="part_number" class="col-sm-2 form-control-label {{ $errors->has('part_number') ? 'text-danger' : '' }}">Product Number:</label>
      <div class="col-sm-4">
        <input type="text" class="form-control {{ $errors->has('part_number') ? 'is-invalid' : '' }}" id="part_number" name="part_number" value="{{ old('part_number') }}">
      </div>
    </div>

    <div class="form-group row">
      <label for="por_id" class="col-sm-2 form-control-label {{ $errors->has('por_id') ? 'text-danger' : '' }}">POR Product Number:</label>
      <div class="col-sm-4">
        <input type="text" class="form-control {{ $errors->has('por_id') ? 'is-invalid' : '' }}" id="por_id" name="por_id" value="{{ old('por_id') }}">
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
        <input type="number" class="form-control {{ $errors->has('quantity') ? 'is-invalid' : '' }}" id="quantity" name="quantity" value="{{ old('quantity') }}">
      </div>
    </div>

    <div class="form-group row">
      <div class="col-md-2 form-control-label">
        Rates:
      </div>

      <div class="row col-md-6">
        <div class="text-center col-6 form-control-label">Period:</div>
        <div class="text-center col-6 form-control-label">Rate:</div>
      </div>

      @for ($i = 0; $i <= 4; $i++)
        <div class="w-100"></div>
        <div class="form-group row offset-md-2 col-md-6">
          <input type="number" class="form-control col-3 {{ $errors->has('rates.' . $i . '.time') ? 'is-invalid' : '' }}" id="rates[{{$i}}][time]" name="rates[{{$i}}][time]" value="{{ old('rates.' . $i . '.time') }}">
          <select class="form-control col-3 {{ $errors->has('rates.' . $i . '.period') ? 'is-invalid' : '' }}" id="rates[{{$i}}][period]" name="rates[{{$i}}][period]">
            <option value="1" {{ old("rates.$i.period") == "1" ? "selected" : "" }}>Hour(s)</option>
            <option value="{{ env('DAY_HOURS', 24 ) }}" {{ old("rates.$i.period") == env('DAY_HOURS', 24) ? "selected" : "" }}>Day(s)</option>
            <option value="{{ env('WEEK_HOURS', 168) }}" {{ old("rates.$i.period") == env('WEEK_HOURS', 168) ? "selected" : "" }}>Week(s)</option>
          </select>
          <input type="number" class="form-control col-6 {{ $errors->has('rates.' . $i . '.rate') ? 'is-invalid' : '' }}" id="rates[{{$i}}][rate]" name="rates[{{$i}}][rate]" value="{{ old('rates.' . $i . '.rate') }}">
        </div>
      @endfor
    </div>

    <div class="form-group row">
      <label for="categories[]" class="col-sm-2 form-control-label {{ $errors->has('categories') ? 'text-danger' : '' }}">Categories:</label>
      <div class="col-sm-10">
        <select multiple class="form-control {{ $errors->has('categories') ? 'is-invalid' : '' }}" id="categories[]" name="categories[]" size="10">
            @foreach ($categories as $category)
            <?php $category_level = 0; ?>
            @include('product.category.category_select_option')
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
