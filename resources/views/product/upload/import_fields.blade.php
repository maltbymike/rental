@extends('layouts.card')

@section('title', 'Map Fields for Upload Products')

@section('heading', 'Map Fields for Upload Products')

@section('breadcrumbs', Breadcrumbs::render('product-upload'))

@section('card-content')

  @include('partials.errors')

  <form class="form-horizontal" method="POST" action="/product/upload/process" enctype="multipart/form-data">
    @CSRF

    <table class="table">
      @foreach ($csv_data as $row)
        <tr>
          @foreach ($row as $key => $value)
            <td>{{ $value }}</td>
          @endforeach
        </tr>
      @endforeach
      <tr>
        @foreach ($csv_data[0] as $key => $value)
          <td>
            <select name="fields[{{ $key }}]">
              @foreach ($db_fields as $db_field)
                <option value="{{ $loop->index }}">{{ $db_field }}</option>
              @endforeach
            </select>
          </td>
        @endforeach
      </tr>
    </table>

    <button type="submit" class="btn btn-primary btn-block">Import Data</button>

  </form>
@endsection
