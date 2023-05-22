@extends('layouts.layout_main')

@section('content') 
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModalScan">Scan QR Code</button>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Tambah Data</button>

    <!-- Table -->
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
            @foreach($datas1 as $key=>$val)
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

            <!-- Modal QR Code -->
            <div class="modal fade" id="ModalQRC{{ $val->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Lihat QR Code</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div> 
                        <div class="modal-body mx-auto py-auto"> 
                        {!! QrCode::size(300)->generate($val->noSertifikat); !!}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button> 
                        </div>  
                    </div>
                </div>
            </div>
            @endforeach
        </tbody>
    </table>

    <!-- Modal Scan -->
    <div class="modal fade" id="ModalScan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Scan QR Code</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div> 
                <div class="modal-body">
                    <div class="text-center">
                        <canvas class="w-100"></canvas>
                        <select></select>
                    </div> 
                    
                    <script type="text/javascript">
                        var arg = {
                            resultFunction: function(result) {
                                //$('.hasilscan').append($('<input name="noijazah" value=' + result.code + ' readonly><input type="submit" value="Cek"/>'));
                                // $.post("../cek.php", { noijazah: result.code} );
                                var redirect = '{{ url("/dokumen/check") }}';
                                $.redirectPost(redirect, {noSertifikat: result.code});
                            }
                        };
                        
                        var decoder = $("canvas").WebCodeCamJQuery(arg).data().plugin_WebCodeCamJQuery;
                        decoder.buildSelectMenu("select");
                        decoder.play();
                        /*  Without visible select menu
                            decoder.buildSelectMenu(document.createElement('select'), 'environment|back').init(arg).play();
                        */
                        $('select').on('change', function(){
                            decoder.stop().play();
                        });

                        // jquery extend function
                        $.extend(
                        {
                            redirectPost: function(location, args)
                            {
                                var form = '';
                                $.each( args, function( key, value ) {
                                    form += '<input type="hidden" name="'+key+'" value="'+value+'">';
                                });
                                $('<form action="'+location+'" method="GET">'+form+'</form>').appendTo('body').submit();
                            }
                        }); 
                    </script>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button> 
                </div>  
            </div>
        </div>
    </div> 

    <!-- Modal Tambah -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Data Sertifikat</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="{{ url('/dokumen/add') }}">
                @csrf
                <div class="modal-body">
                    <div class="form-floating mb-3">
                        <input name="noPeserta" type="text" class="form-control" id="floatingInput" placeholder="nama">
                        <label for="floatingInput">No Peserta</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input name="nama" type="text" class="form-control" id="floatingInput" placeholder="nama">
                        <label for="floatingInput">Nama</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input name="instansi" type="text" class="form-control" id="floatingInput" placeholder="nama">
                        <label for="floatingInput">Instansi</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input name="tanggalTerbit" type="text" class="form-control" id="floatingInput" placeholder="nama">
                        <label for="floatingInput">Tanggal Terbit</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input name="noSertifikat" type="text" class="form-control" id="floatingInput" placeholder="nama">
                        <label for="floatingInput">No Sertifikat</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input name="namaPelatihan" type="text" class="form-control" id="floatingInput" placeholder="nama">
                        <label for="floatingInput">Nama Pelatihan</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input name="keikutsertaan" type="text" class="form-control" id="floatingInput" placeholder="nama">
                        <label for="floatingInput">Keikutsertaan</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div> 
                </form>
            </div>
        </div>
    </div> 
@endsection
