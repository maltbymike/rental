@extends('layouts.card')

@section('title', 'Create Product Category')

@section('heading', 'Create Product Category')

@section('card-content')

  @include('partials.errors')

  <form method="post" action="/product/category">

    @CSRF

    <div class="form-group row">
      <label for="name" class="col-sm-2 form-control-label {{ $errors->has('name') ? 'text-danger' : '' }}">Category Name:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" id="name" name="name" value="{{ old('name') }}" placeholder="Category Name" required>
      </div>
    </div>

    <div class="form-group row">
      <label for="description" class="col-sm-2 form-control-label {{ $errors->has('description') ? 'text-danger' : '' }}">Description:</label>
      <div class="col-sm-10">
        <textarea name="description" id="description" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}">{{ old('description') }}</textarea>
      </div>
    </div>

    <div class="form-group row">
      <label for="parent_id" class="col-sm-2 form-control-label {{ $errors->has('parent_id') ? 'text-danger' : '' }}">Parent Category:</label>
      <div class="col-sm-10">
        <select class="form-control {{ $errors->has('parent_id') ? 'is-invalid' : '' }}" id="parent_id" name="parent_id">
          <option value="">Root Category</option>
          @foreach ($categories as $id => $name)
            <option value="{{ $id }}" {{ old("parent_id") == $id ? "selected" : "" }}>{{ $name }}</option>
          @endforeach
        </select>
      </div>
    </div>

    <div class="form-group row">
      <label for="slug" class="col-sm-2 form-control-label {{ $errors->has('slug') ? 'text-danger' : '' }}">Category Slug:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control {{ $errors->has('slug') ? 'is-invalid' : '' }}" name="slug" id="slug" value="{{ old('slug') }}" placeholder="category-slug">
      </div>
    </div>

    <div class="form-group row">
      <label for="inactive" class="col-sm-2 form-check-label {{ $errors->has('inactive') ? 'text-danger' : '' }}">Category is Inactive:</label>
      <div class="col-sm-10">
        <div class="form-check">
          <input type="checkbox" class="form-check-input" name="inactive" id="inactive" {{ old("inactive") == TRUE ? "checked" : "" }} />
        </div>
      </div>
    </div>

    <input type="submit" class="btn btn-primary btn-lg btn-block" value="Create Category" />

  </form>
@endsection
