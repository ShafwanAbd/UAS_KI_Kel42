@extends('layouts.layout_main')

@section('content') 
 
<div class="row"> 
    @if(Session::has('success'))
    <p class="fixed-top mx-auto w-50 alert alert-success" id="sixSeconds" style="margin-top: 7.5vh">{{ Session::get('success') }}</p>
    @elseif (Session::has('failed'))
    <p class="fixed-top mx-auto w-50 alert alert-danger" id="sixSeconds" style="margin-top: 7.5vh">{{ Session::get('failed') }}</p> 
    @endif
</div>

<div class="container" style="margin: 15vh auto;">

    <div class="text-center" style="margin: 15vh auto;">
        <h1>QRSave</h1>
        <h6>Jl. Siliwangi, Tugujaya, Kec. Cihideung, Kab. Tasikmalaya, Jawa Barat 46126</h6>
    </div>

    @if (isset($model1))
    <table class="table table-hover table-bordered border-dark">
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
                        $model1->created_at.
                        $model1->id.
                        $model1->noPeserta.
                        $model1->nama.
                        $model1->asalSekolah.
                        $model1->tanggalTerbit.
                        $model1->noSertifikat.
                        $model1->namaPelatihan.
                        $model1->keikutsertaan.
                        $model1->updated_at
                    );     
                    
                    ($message == $decryptedMessage) ? $message1 = 1 : $message1 = 0;   
                    $dsa->verify($message, $model1->sign) ? $message2 = 1 : $message2 = 0;   

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
                @if ($message == 1)
                <td>
                    <button type="button" class="badge bg-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Data Masih Sama Seperti pada Awal Dibuat.">
                        Valid
                    </button>
                </td>
                @else
                <td>
                    <button type="button" class="badge bg-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Data Sudah Tidak Sama Seperti Awal Dibuat.">
                        Invalid
                    </button>
                </td>
                @endif
                </td>
            </tr>  
        </tbody> 
    </table>
    @else
    <div class="card p-5 m-5">
        <h3>Sertifikat Tidak Terdaftar!</h3>
    </div>
    @endif
</div>

<script>
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
</script>
@endsection
