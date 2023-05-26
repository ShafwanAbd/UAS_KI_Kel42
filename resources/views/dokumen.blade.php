@extends('layouts.layout_main')

@section('content')


<div class="container">
 
 <div class="row"> 
     @if(Session::has('success'))
     <p class="fixed-top mx-auto w-50 alert alert-success" id="sixSeconds" style="margin-top: 7.5vh">{{ Session::get('success') }}</p>
     @elseif (Session::has('failed'))
     <p class="fixed-top mx-auto w-50 alert alert-danger" id="sixSeconds" style="margin-top: 7.5vh">{{ Session::get('failed') }}</p> 
     @endif
 </div>

  <div class="d-row d-flex pt-3 gap-2">
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#ModalScan">Scan QR
      Code</button>
    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">Tambah
      Data</button>
  </div>

  <!-- Table -->
  <div class="row pt-3">
    <table id="example" class="table table-striped" style="width:100%; font-size:small">
      <thead>
        <tr>
          <th>No</th>
          <th>No Peserta</th>
          <th>Nama</th>
          <th>Instansi</th>
          <th>Tanggal Terbit</th>
          <th>Nomor Sertifikat</th>
          <th>Nama Program</th>
          <th>Keikutsertaan</th>
          <th>Validitas</th>
          <th>QR Code</th>
          <th>Action</th>
        </tr>
      </thead>

      <tbody>
        @php
        $i = 1;
        @endphp
        @foreach($datas1 as $key=>$val)
        @php
        $message = (
        $val->created_at.
        $val->id.
        $val->noPeserta.
        $val->nama.
        $val->asalSekolah.
        $val->tanggalTerbit.
        $val->noSertifikat.
        $val->namaPelatihan.
        $val->keikutsertaan.
        $val->updated_at
        );

        // Seharusnya pake $dsa
        $dsa->verify($message, $val->sign) ? $message2 = 1 : $message2 = 0;

        ($message2 == 1) ? $message = 1 : $message = 0;
        @endphp
        <tr>
          <td>{{ $i++ }}</td>
          <td>{{ $val->noPeserta }}</td>
          <td>{{ $val->nama }}</td>
          <td>{{ $val->instansi }}</td>
          <td>{{ $val->tanggalTerbit }}</td>
          <td>{{ $val->noSertifikat }}</td>
          <td>{{ $val->namaPelatihan }}</td>
          <td>{{ $val->keikutsertaan }}</td>
          @if ($message == 1)
          <td>
            <button type="button" class="badge bg-success" data-bs-toggle="tooltip" data-bs-placement="top"
              data-bs-custom-class="custom-tooltip" data-bs-title="Data Masih Sama Seperti pada Awal Dibuat.">
              Valid
            </button>
          </td>
          @else
          <td>
            <button type="button" class="badge bg-danger" data-bs-toggle="tooltip" data-bs-placement="top"
              data-bs-custom-class="custom-tooltip" data-bs-title="Data Sudah Tidak Sama Seperti Awal Dibuat.">
              Invalid
            </button>
          </td>
          @endif
          <td scope="col"><button class="btn btn-primary btn-sm" data-bs-toggle="modal"
              data-bs-target="#ModalQRC{{ $val->id }}">Lihat</button></td>
          <td scope="col"><button class="btn btn-danger btn-sm" data-bs-toggle="modal"
              data-bs-target="#ModalHapus{{ $val->id }}">Hapus</button></td>
        </tr>

        <!-- Modal QR Code -->
        <div class="modal fade" id="ModalQRC{{ $val->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
          aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Lihat QR Code</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body mx-auto py-auto">
                <div id="QRDownloadThis{{$val->id}}">
                  {!! QrCode::size(300)->margin(1)->errorCorrection('H')->generate($val->uniqueId); !!}
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                <a id="btnDownload{{$val->id}}" type="button" class="btn btn-primary">Download</a>
              </div>

              <script>
              $(document).ready(function() {
                $('#btnDownload{{$val->id}}').click(function() {
                  domtoimage.toBlob(document.getElementById('QRDownloadThis{{$val->id}}'))
                    .then(function(blob) {
                      window.saveAs(blob, 'QRCode-{{$val->noPeserta}}.png');
                    });
                });
              });
              </script>

            </div>
          </div>
        </div>

        <!-- Modal Hapus -->
        <div class="modal fade" id="ModalHapus{{ $val->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
          aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Konfirmasi Hapus Data</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body mx-auto py-auto">
                <h6>Apakah Anda Yakin Ingin Menghapus data {{ $val->nama }}?</h6>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Gajadi</button>
                <a href="{{ url('dokumen/hapus/'.$val->id) }}" class="btn btn-danger">Yakin</a>
              </div>
            </div>
          </div>
        </div>
        @endforeach
      </tbody>
    </table>
  </div>

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
          $(document).ready(function() {
            var decoder; // Declare the decoder variable outside the scope of the event handlers

            // Open ModalScan event handler
            $('#ModalScan').on('shown.bs.modal', function() {
              var arg = {
                resultFunction: function(result) {
                  var redirect = '{{ url("/dokumen/check") }}';
                  $.redirectPost(redirect, {
                    uniqueId: result.code
                  });
                }
              };

              // Initialize the decoder when the modal is opened
              decoder = $("canvas").WebCodeCamJQuery(arg).data().plugin_WebCodeCamJQuery;
              decoder.buildSelectMenu("select");
              decoder.play();
            });

            // Close ModalScan event handler
            $('#ModalScan').on('hidden.bs.modal', function() {
              // Stop the decoder when the modal is closed
              if (decoder) {
                decoder.stop();
              }
            });

            $.extend({
              redirectPost: function(location, args) {
                var form = '';
                $.each(args, function(key, value) {
                  form += '<input type="hidden" name="' + key + '" value="' + value + '">';
                });
                $('<form action="' + location + '" method="GET">' + form + '</form>').appendTo('body')
                  .submit();
              }
            });
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
              <input name="noPeserta" type="text" class="form-control" id="floatingInput" placeholder="nama" required>
              <label for="floatingInput">No Peserta</label>
            </div>
            <div class="form-floating mb-3">
              <input name="nama" type="text" class="form-control" id="floatingInput" placeholder="nama" required>
              <label for="floatingInput">Nama</label>
            </div>
            <div class="form-floating mb-3">
              <input name="instansi" type="text" class="form-control" id="floatingInput" placeholder="nama" required>
              <label for="floatingInput">Instansi</label>
            </div>
            <div class="form-floating mb-3">
              <input name="tanggalTerbit" type="date" class="form-control" id="floatingInput" placeholder="nama"
                required>
              <label for="floatingInput">Tanggal Terbit</label>
            </div>
            <div class="form-floating mb-3">
              <input name="noSertifikat" type="text" class="form-control" id="floatingInput" placeholder="nama"
                required>
              <label for="floatingInput">No Sertifikat</label>
            </div>
            <div class="form-floating mb-3">
              <input name="namaPelatihan" type="text" class="form-control" id="floatingInput" placeholder="nama"
                required>
              <label for="floatingInput">Nama Pelatihan</label>
            </div>
            <div class="form-floating mb-3">
              <input name="keikutsertaan" type="text" class="form-control" id="floatingInput" placeholder="nama"
                required>
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
</div>

<script>
const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
</script>
@endsection