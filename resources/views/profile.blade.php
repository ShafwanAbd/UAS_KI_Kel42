@extends('layouts.layout_main')

@section('content')
 
<div class="row"> 
    @if(Session::has('success'))
    <p class="fixed-top mx-auto w-50 alert alert-success" id="sixSeconds" style="margin-top: 7.5vh">{{ Session::get('success') }}</p>
    @elseif (Session::has('failed'))
    <p class="fixed-top mx-auto w-50 alert alert-danger" id="sixSeconds" style="margin-top: 7.5vh">{{ Session::get('failed') }}</p> 
    @endif
</div>


<div class="container d-flex justify-content-center align-items-center"
  style="max-width: 1200px; min-height: 1400px; margin-top: -30px;">

  <div class="card border-0 shadow p-5 w-75 gap-5 my-5">
    <div class="card body top p-4 px-5 gap-3">
      <h5 class="my-3 fw-bold">Profile</h5>
      <div class="row text-center justify-content-center align-items-center">
        <form class="" method="POST" action="{{ url('profile/update') }}">
          @csrf
          <div class="mb-3 text-start">
            <label for="name" class="pb-1">Nama Pengguna:</label>
            <input name="name" id="name" class="form-control w-100" type="text" value="{{ $user->name }}">

          </div>
          <div class="mb-3 text-start">
            <label for="name" class="pb-1">Email:</label>
            <input name="email" type="text" class="form-control w-100" value="{{ $user->email }}">
          </div>
          <button type=" submit" class="btn btn-primary px-4">Update</button>

        </form>
      </div>

    </div>
    <div class="card body mid p-4 px-5 gap-3">
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

            <div class="text-center"> 
                <button type="submit" class="btn btn-primary px-4">Update</button>
            </div>

        </form> 
 
        <script>  
            const hashedPassword = document.querySelector('#hashedPassword').value;
            const currentPwField = document.querySelector('#currentPassword');
            const newPwField = document.querySelector('input[name="new_pw"]');
            const confirmPwField = document.querySelector('input[name="new_pw_confirm"]');
            let newPwValue = newPwField.value;
            let confirmPwValue = confirmPwField.value; 

            currentPwField.addEventListener('input', () => {
                let currentPwValue = currentPwField.value; 

                console.log(currentPwValue);
                console.log(hashedPassword);

                if (bcrypt.compareSync(currentPwValue, hashedPassword)) {
                    currentPwField.setCustomValidity('');
                    console.log('success');
                } else { 
                    currentPwField.setCustomValidity('Passowrd Salah!');
                    console.log('fail');
                }
            });

            newPwField.addEventListener('input', () => {
                newPwValue = newPwField.value;
                confirmPwValue = confirmPwField.value;

                if (newPwValue !== confirmPwValue) {
                    confirmPwField.setCustomValidity('Passowrd Tidak Sesuai!');
                } else if (newPwValue.length < 6) {    
                    confirmPwField.setCustomValidity('Password minimal berjumlah 6 karakter!');
                } else if (!/[A-Z]/.test(confirmPwValue)) {
                    confirmPwField.setCustomValidity('Password minimal mempunyai satu huruf besar!');
                } else if (!/[!@#$%^&*]/.test(confirmPwValue)) {
                    confirmPwField.setCustomValidity('Password minimal mempunyai satu spesial simbol!');
                } else { 
                    confirmPwField.setCustomValidity('');
                }
            });

            confirmPwField.addEventListener('input', () => {
                newPwValue = newPwField.value;
                confirmPwValue = confirmPwField.value;

                if (newPwValue !== confirmPwValue) {
                    confirmPwField.setCustomValidity('Passowrd Tidak Sesuai!');
                } else if (newPwValue.length < 6) {    
                    confirmPwField.setCustomValidity('Password minimal berjumlah 6 karakter!');
                } else if (!/[A-Z]/.test(confirmPwValue)) {
                    confirmPwField.setCustomValidity('Password minimal mempunyai satu huruf besar!');
                } else if (!/[!@#$%^&*]/.test(confirmPwValue)) {
                    confirmPwField.setCustomValidity('Password minimal mempunyai satu spesial simbol!');
                } else { 
                    confirmPwField.setCustomValidity('');
                }
            });

            const form = document.querySelector('#submitBtn');
            form.addEventListener('submit', () => {  
                if (newPwValue !== confirmPwValue) { 
                    event.preventDefault();
                }
            });
        </script>
        </div>
    </div>
    <div class="card body bottom p-4 px-5 gap-3">
      <h5 class="mt-3 fw-bold">Key</h5>
      <div class="mb-2">
        <label for="exampleFormControlTextarea1" class="form-label">Private Key:</label>
        <textarea name="privateKey" type="text" class="form-control" id="exampleFormControlTextarea1" rows="4"
          disabled>{{ $setting->privateKey }}</textarea>
      </div>
      <div class="mb-2">
        <label for="exampleFormControlTextarea2" class="form-label">Public Key:</label>
        <textarea name="publicKey" type="text" class="form-control" id="exampleFormControlTextarea1" rows="4"
          disabled>{{ $setting->publicKey }}</textarea>
      </div>
      <div class="mb-3">
        <label for="form-control" class="form-label">Encryption Key:</label>
        <input name="encryptionKey" class="form-control" type="text" class="form-control"
          value="{{ $setting->encryptionKey}}" disabled>
      </div>

      @endsection