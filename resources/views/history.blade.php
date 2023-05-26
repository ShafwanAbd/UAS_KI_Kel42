@extends('layouts.layout_main')

@section('content')

<div class="container">
  <div class="row pt-3">


    <table id="example" class="table table-striped" style="width:100%;">
      <thead>
        <tr>
          <th scope="col">No</th>
          <th scope="col">Waktu</th>
          <th scope="col">Aktifitas</th>
        </tr>
      </thead>
      <tbody>
        @php $i = 1; @endphp
        @foreach($datas1 as $key=>$val)
        <tr>
          <td scope="col">{{ $i++ }}</td>
          <td scope="col">{{ $val->created_at }}</td>
          <td scope="col">{{ $val->aktifitas }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>


  </div>
</div>
@endsection