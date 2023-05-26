@extends('layouts.layout_main')

@section('content')

@if(Session::has('success'))
    <p class="alert alert-success" id="sixSeconds">{{ Session::get('success') }}</p>
@elseif (Session::has('failed'))
    <p class="alert alert-danger" id="sixSeconds">{{ Session::get('failed') }}</p>
@endif 

<form class="" method="POST" action="{{ url('profile/update') }}">
@csrf
    <input name="name" type="text" value="{{ $user->name }}">
    <input name="email" type="text" value="{{ $user->email }}">  
    <button type="submit" class="btn btn-primary">Update</button>
</form>

<form method="POST" action="{{ url('profile/updatePassword') }}">
@csrf
    <div class="">
        <div class="container_form flex">
            <div class="container_form_label">
                <input id="hashedPassword" type="hidden" value="{{ Auth::user()->password }}"> 
                <div class="item flex">
                    <p>Kata Sandi Sekarang</p>
                    <div class="input-group">
                        <span id="hideButton1" class="input-group-text"><img class="animate__animated animate__flipInX" id="hideImage1" src="{{ asset('./image/icon/view_grey.png') }}"></span>
                        <input id="currentPassword" class="form-control" name="current_pw" placeholder="Password Aktif" type="password" required> 
                    </div>
                </div>
                <div class="item flex">
                    <p>Kata Sandi Baru</p>
                    <div class="input-group">
                        <span id="hideButton2" class="input-group-text"><img class="animate__animated animate__flipInX" id="hideImage2" src="{{ asset('./image/icon/view_grey.png') }}"></span>
                        <input id="newPassword" class="form-control" name="new_pw" placeholder="Password Baru" type="password" required> 
                    </div>
                </div>
                <div class="item flex">
                    <p>Konfirmasi Kata Sandi</p>
                    <div class="input-group">
                        <span id="hideButton3" class="input-group-text"><img class="animate__animated animate__flipInX" id="hideImage3" src="{{ asset('./image/icon/view_grey.png') }}"></span>
                        <input id="newPasswordConfirm" class="form-control" name="new_pw_confirm" placeholder="Password Baru" type="password" required> 
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
        <button type="submit" class="btn btn-primary">Update</button>
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
                confirmPwField.setCustomValidity('Password minimal berjumlah 8 karakter!');
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
                confirmPwField.setCustomValidity('Password minimal berjumlah 8 karakter!');
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

    <textarea name="privateKey" type="text" disabled>{{ $setting->privateKey }}</textarea>
    <textarea name="publicKey" type="text" disabled>{{ $setting->publicKey }}</textarea>
    <input name="encryptionKey" type="text" value="{{ $setting->encryptionKey}}" disabled>   

@endsection
