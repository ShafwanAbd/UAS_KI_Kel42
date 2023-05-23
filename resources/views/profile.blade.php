@extends('layouts.layout_main')

@section('content')
<form method="POST" action="{{ url('profile/update') }}">
@csrf
    <input name="name" type="text" value="{{ $user->name }}">
    <input name="email" type="text" value="{{ $user->email }}"> 
    <textarea name="privateKey" type="text">{{ $user->privateKey }}</textarea>
    <textarea name="publicKey" type="text">{{ $user->publicKey }}</textarea>
    <input name="encryptionKey" type="text" value="{{ $user->encryptionKey}}">   
    <button type="submit" class="btn btn-primary">Update</button>
</form>

@endsection
