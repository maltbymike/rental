@extends('layouts.card')

@section('title', 'Upload Products')

@section('heading', 'Upload Products')

@section('breadcrumbs', Breadcrumbs::render('product-upload'))

@section('card-content')

  @include('partials.errors')

  <form method="POST" action="/product/upload" enctype="multipart/form-data">
    @CSRF

    <div class="form-group row">
      <label for="file" class="form-control-label col-sm-2"><strong>CSV File to import</strong></label>
      <input id="file" type="file" class="form-control-file col-sm-10 {{ $errors->has('file') ? 'is-invalid' : '' }}" name="file" required>
    </dvi>

    <button type="submit" class="btn btn-primary btn-lg btn-block mt-4 mb-4" name="submit"><i class="fa fa-check"></i> Upload</button>

  </form>

  <label for="pendingfiles" class="form-control-label"><strong>Pending Files in Upload Queue</strong></label>
  <select class="form-control" id="pendingfiles">
    @foreach ($pendingfiles as $file)
      <option>$file</option>
    @endforeach
  </select>

  <script>
    // Add the following code if you want the name of the file appear on select
    $("#file").on("change", function() {
      var fileName = $(this).val();
      $(this).next(".custom-file-label").html(fileName);
    });
  </script>

@endsection
