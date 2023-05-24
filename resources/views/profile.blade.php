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
    <div class="">
        <p>Password</p>
        <div class="input-group">
            <span id="hideButton1" class="input-group-text justify-content-center"><img class="animate__animated animate__flipInX w-75" id="hideImage1" src="{{ asset('./image/icon/view_grey.png') }}"></span>
            <input id="currentPassword" class="form-control" name="current_pw" placeholder="Password Aktif" type="password" required> 
        </div>
    </div>
    <textarea name="privateKey" type="text" disabled>{{ $user->privateKey }}</textarea>
    <textarea name="publicKey" type="text" disabled>{{ $user->publicKey }}</textarea>
    <input name="encryptionKey" type="text" value="{{ $user->encryptionKey}}" disabled>   

    <button type="submit" class="btn btn-primary">Update</button>
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
