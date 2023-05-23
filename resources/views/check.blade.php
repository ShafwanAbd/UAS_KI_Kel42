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
            <th scope="col">Validitas</th>
        </tr>
    </thead>
    <tbody> 
        <tr>
            @php 
                $message = (
                    $model1->noPeserta.
                    $model1->nama.
                    $model1->asalSekolah.
                    $model1->tanggalTerbit.
                    $model1->noSertifikat.
                    $model1->namaPelatihan.
                    $model1->keikutsertaan
                );   

                ($message == $decryptedMessage) ? $message1 = 1 : $message1 = 0;   
                $dsa->verify($decryptedMessage, $model1->sign) ? $message2 = 1 : $message2 = 0;   

                ($message1 == 1 && $message2 == 1) ? $message = 1 : $message = 0;
            @endphp
            <td scope="col">1</td> 
            <td scope="col">{{ $model1->noPeserta }}</td>
            <td scope="col">{{ $model1->nama }}</td>
            <td scope="col">{{ $model1->instansi }}</td>
            <td scope="col">{{ $model1->tanggalTerbit }}</td>
            <td scope="col">{{ $model1->noSertifikat }}</td>
            <td scope="col">{{ $model1->namaPelatihan }}</td>
            <td scope="col">{{ $model1->keikutsertaan }}</td> 
            <td scope="col">
                @if ($message == 1)
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModalQRC{{ $model1->id }}">Valid</button>
                @else                
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModalQRC{{ $model1->id }}">Invalid</button>
                @endif
            </td>
        </tr>  
    </tbody> 
</table>
@endsection
