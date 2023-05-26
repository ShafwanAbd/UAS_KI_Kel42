@extends('layouts.layout_main')

@section('content')

@if(Session::has('success'))

<div class="row m-5">
  <p class="alert alert-success" id="sixSeconds">{{ Session::get('success') }}</p>
  @elseif (Session::has('failed'))
  <p class="alert alert-danger" id="sixSeconds">{{ Session::get('failed') }}</p>
</div>

@endif

<div class="container d-flex justify-content-center align-items-center"
  style="max-width: 1200px; min-height: 1400px; margin-top: -30px;">

  <div class="card border-0 shadow p-5" style="width: 32rem; ">
    <div class="card body top p-3">
      <h5 class="my-3 fw-bold">Profile</h5>
      <div class="row text-center justify-content-center align-items-center">
        <form class="" method="POST" action="{{ url('profile/update') }}">
          @csrf
          <div class="mb-3 text-start">
            <label for="name" class="pb-1">Nama Pengguna:</label>
            <input name="name" id="name" class="form-control " type="text" value="{{ $user->name }}"
              style="width: 24rem; ">

          </div>
          <div class="mb-3 text-start">
            <label for="name" class="pb-1">Email:</label>
            <input name="email" type="text" class="form-control" value="{{ $user->email }}" style="width: 24rem;">
          </div>
          <button type=" submit" class="btn btn-primary px-4">Update</button>

        </form>
      </div>

    </div>
    <div class="card body mid p-3 mt-2">
      <h5 class="my-3 fw-bold">Kata Sandi</h5>
      <form method="POST" action="{{ url('profile/updatePassword') }}">
        @csrf
        <div class="">
          <div class="container_form flex">
            <div class="container_form_label">
              <input id="hashedPassword" type="hidden" value="{{ Auth::user()->password }}">
              <div class="item flex">

                <label for="currentPassword" class="pb-1">Kata Sandi Sekarang:</label>
                <div class="input-group mb-3">
                  <span id="hideButton1" class="input-group-text"><img class="animate__animated animate__flipInX"
                      id="hideImage1" src="{{ asset('./image/icon/view_grey.png') }}" width="20px" height="auto"></span>
                  <input id="currentPassword" class="form-control" name="current_pw" placeholder="Password Aktif"
                    type="password" required>
                </div>
              </div>
              <div class="item flex">
                <label for="currentPassword" class="pb-1">Kata Sandi Baru:</label>
                <div class="input-group mb-3">
                  <span id="hideButton2" class="input-group-text"><img class="animate__animated animate__flipInX"
                      id="hideImage2" src="{{ asset('./image/icon/view_grey.png') }}" width="20px" height="auto"></span>
                  <input id="newPassword" class="form-control" name="new_pw" placeholder="Password Baru" type="password"
                    required>
                </div>
              </div>
              <div class="item flex">
                <label for="currentPassword" class="pb-1">Konfirmasi Kata Sandi:</label>
                <div class="input-group mb-3">
                  <span id="hideButton3" class="input-group-text"><img class="animate__animated animate__flipInX"
                      id="hideImage3" src="{{ asset('./image/icon/view_grey.png') }}" width="20px" height="auto"></span>
                  <input id="newPasswordConfirm" class="form-control" name="new_pw_confirm" placeholder="Password Baru"
                    type="password" required>
                </div>
              </div>
            </div>

            <script>
            $(document).ready(function() {
              $('#hideButton1').click(function() {
                var imageElement = $('#hideImage1');
                var passwordField = $('#currentPassword');
                var passwordFieldType = passwordField.attr('type');

                if (passwordFieldType === 'password') {
                  passwordField.attr('type', 'text');
                  imageElement.attr('src', '{{asset("./image/icon/view_grey_closed.png")}}')
                } else {
                  passwordField.attr('type', 'password');
                  imageElement.attr('src', "{{asset('./image/icon/view_grey.png')}}")
                }

                imageElement.toggleClass('animate__animated animate__flipInX');
                setTimeout(function() {
                  imageElement.toggleClass('animate__animated animate__flipInX');
                }, 0);

              });
              $('#hideButton2').click(function() {
                var imageElement = $('#hideImage2');
                var passwordField = $('#newPassword');
                var passwordFieldType = passwordField.attr('type');

                if (passwordFieldType === 'password') {
                  passwordField.attr('type', 'text');
                  imageElement.attr('src', '{{asset("./image/icon/view_grey_closed.png")}}')
                } else {
                  passwordField.attr('type', 'password');
                  imageElement.attr('src', "{{asset('./image/icon/view_grey.png')}}")
                }

                imageElement.toggleClass('animate__animated animate__flipInX');
                setTimeout(function() {
                  imageElement.toggleClass('animate__animated animate__flipInX');
                }, 0);
              });
              $('#hideButton3').click(function() {
                var imageElement = $('#hideImage3');
                var passwordField = $('#newPasswordConfirm');
                var passwordFieldType = passwordField.attr('type');

                if (passwordFieldType === 'password') {
                  passwordField.attr('type', 'text');
                  imageElement.attr('src', '{{asset("./image/icon/view_grey_closed.png")}}')
                } else {
                  passwordField.attr('type', 'password');
                  imageElement.attr('src', "{{asset('./image/icon/view_grey.png')}}")
                }

                imageElement.toggleClass('animate__animated animate__flipInX');
                setTimeout(function() {
                  imageElement.toggleClass('animate__animated animate__flipInX');
                }, 0);
              });
            });
            </script>
          </div>
          <div class="row text-center" style="margin-left: 128px; margin-right: 128px">
            <button type="submit" class="btn btn-primary">Update</button>
          </div>
        </div>
    </div>
    <div class="card body bottom p-3 mt-2 gap-3">
      <h5 class="mt-3 fw-bold">Key</h5>
      <div class="mb-2">
        <label for="exampleFormControlTextarea1" class="form-label">Private Key:</label>
        <textarea name="privateKey" type="text" class="form-control" id="exampleFormControlTextarea1" rows="3"
          disabled>{{ $setting->privateKey }}</textarea>
      </div>
      <div class="mb-2">
        <label for="exampleFormControlTextarea2" class="form-label">Public Key:</label>
        <textarea name="publicKey" type="text" class="form-control" id="exampleFormControlTextarea1" rows="3"
          disabled>{{ $setting->publicKey }}</textarea>
      </div>
      <div class="mb-3">
        <label for="form-control" class="form-label">Encryption Key:</label>
        <input name="encryptionKey" class="form-control" type="text" class="form-control"
          value="{{ $setting->encryptionKey}}" disabled>
      </div>

      </form>


      <script>
      $(document).ready(function() {
        $('#hideButton1').click(function() {
          var imageElement = $('#hideImage1');
          var passwordField = $('#currentPassword');
          var passwordFieldType = passwordField.attr('type');

          if (passwordFieldType === 'password') {
            passwordField.attr('type', 'text');
            imageElement.attr('src', '{{asset("./image/icon/view_grey_closed.png")}}')
          } else {
            passwordField.attr('type', 'password');
            imageElement.attr('src', "{{asset('./image/icon/view_grey.png')}}")
          }

          imageElement.toggleClass('animate__animated animate__flipInX');
          setTimeout(function() {
            imageElement.toggleClass('animate__animated animate__flipInX');
          }, 1);
        });
      });
      </script>
      @endsection