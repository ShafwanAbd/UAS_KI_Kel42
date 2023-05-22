@extends('layouts.layout_main')

@section('content')

<h1>Codingy</h1>
<h6>Jl. Siliwangi, Planet Mars, Universe Milky Way</h6>

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
            <td scope="col">{{ $model1->noPeserta }}</td>
            <td scope="col">{{ $model1->nama }}</td>
            <td scope="col">{{ $model1->instansi }}</td>
            <td scope="col">{{ $model1->tanggalTerbit }}</td>
            <td scope="col">{{ $model1->noSertifikat }}</td>
            <td scope="col">{{ $model1->namaPelatihan }}</td>
            <td scope="col">{{ $model1->keikutsertaan }}</td> 
            <td scope="col">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModalQRC{{ $model1->id }}">Cek Validitas</button>
            </td>
        </tr>  
    </tbody> 
</table>
@endsection
