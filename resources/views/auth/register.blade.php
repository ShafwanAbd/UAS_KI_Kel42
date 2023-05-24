@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="max-width: 600px; min-height: 600px; margin-top: -30px;">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card rounded border-0 shadow" style="width: 28rem; ">
                <div class="card-header border-0 text-center fw-bold fs-4 text-uppercase mt-2">{{ __('Register') }}</div>

                <div class="card-body text-center px-5">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-floating mb-3">



                            <input id="floatingInput" type="text" class="form-control shadow @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                            <label for="floatingInput">Name</label>
                        </div>


                        <div class="form-floating mb-3">


                            <input id="floatingInput" type="email" class="form-control shadow @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                            <label for="floatingInput">Email</label>

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>


                        <div class="form-floating mb-3">



                            <input id="floatingInput" type="password" class="form-control shadow @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            <label for="floatingInput">Password</label>

                        </div>

                        <div class="form-floating mb-3">


                            <input id="floatingInput" type="password" class="form-control shadow" name="password_confirmation" required autocomplete="new-password">
                            <label for="floatingInput">Password</label>

                        </div>

                        <div class="text-center mb-2">

                            <button type="submit" class="btn px-5 py-2 fw-bold" style="background-color: #020202; color:white">
                                {{ __('Register') }}
                            </button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection