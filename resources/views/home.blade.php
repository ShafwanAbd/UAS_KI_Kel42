@extends('layouts.layout_main')

@section('content')
 
 <div class="row"> 
     @if(Session::has('success'))
     <p class="fixed-top mx-auto w-50 alert alert-success" id="sixSeconds" style="margin-top: 7.5vh">{{ Session::get('success') }}</p>
     @elseif (Session::has('failed'))
     <p class="fixed-top mx-auto w-50 alert alert-danger" id="sixSeconds" style="margin-top: 7.5vh">{{ Session::get('failed') }}</p> 
     @endif
 </div>

<div class="container d-flex align-items-center" style="max-width: 1200px; min-height: 600px; margin-top: -30px;">

    <div class="row text-start p-5 mt-5">
        <div class="col-md-5 ps-5">
            <h1 style="font-family: 'Patua One', cursive; color: #020202">Amankan Dokumenmu dengan QRSave</h1>
            <p class="pt-2" style="font-family: 'Catamaran', sans-serif; color: #020202">Pengamanan dokumen menggunakan
                teknologi QR memakai
                Algoritma AES
                dan DSA. </p>
            <div class="tombol pt-2">
                <button class="btn me-2 btn-sm rounded" style="padding: 11px; background-color: #020202; color: white;" data-bs-toggle="modal" data-bs-target="#ModalScan">Cek
                    Keaslian
                    Dokumen</button>
                <a href="{{ url('/dokumen') }}" class="btn btn-outline-dark" style="padding: 11px;">Amankan Dokumen</a>
            </div>
        </div>
        <div class="col-md-7 text-center">
            <img class="ms-5" src="{{ asset('/image/icon/home.jpg') }}" alt="" height="350px" width="auto">
        </div>
    </div>

    <!-- Button trigger modal -->
    <!-- <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#ModalScan">Scan QR
    Code</button> -->

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

</div>
@endsection