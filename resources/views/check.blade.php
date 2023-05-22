@extends('layouts.layout_main')

@section('content')

<table class="table table-hover">
    <thead>
        <tr>
            <th scope="col">No</th>
            <th scope="col">No Peserta</th>
            <th scope="col">Nama</th>
            <th scope="col">Instansi</th>
            <th scope="col">Tanggal Terbit</th>
            <th scope="col">Nomor Sertifikat</th>
            <th scope="col">Nama Program</th>
            <th scope="col">Keikutsertaan</th>
            <th scope="col">QR Code</th>
        </tr>
    </thead>
    <tbody> 
        <tr>
            <td scope="col">1</td>
            <td scope="col">{{ $val->noPeserta }}</td>
            <td scope="col">{{ $val->nama }}</td>
            <td scope="col">{{ $val->instansi }}</td>
            <td scope="col">{{ $val->tanggalTerbit }}</td>
            <td scope="col">{{ $val->noSertifikat }}</td>
            <td scope="col">{{ $val->namaPelatihan }}</td>
            <td scope="col">{{ $val->keikutsertaan }}</td>
            <td scope="col"><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModalQRC{{ $val->id }}">Lihat</button></td>
        </tr>  
    </tbody> 
</table>
@endsection
