@extends('layouts.layout_main')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div> 
 
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#ModalScan">Scan QR
        Code</button> 

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
