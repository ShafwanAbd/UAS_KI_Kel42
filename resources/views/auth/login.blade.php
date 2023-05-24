@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center"
  style="max-width: 600px; min-height: 600px; margin-top: -30px;">
  <div class="row justify-content-center">
    <div class="col-lg-12">
      <div class="card rounded border-0 shadow" style="width: 28rem; ">
        <div class="card-header border-0 text-center fw-bold fs-4 text-uppercase mt-2">{{ __('Login') }}</div>

        <div class="card-body text-center px-5">
          <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-floating mb-3">
              <input id="floatingInput" type="email" class="form-control shadow @error('email') is-invalid @enderror"
                name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                placeholder="Masukkan Email">
              <label for="floatingInput">Email</label>

              @error('email')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror

            </div>

            <div class="form-floating mb-3">



              <input id="floatingInput" type="password"
                class="form-control shadow @error('password') is-invalid @enderror" name="password" required
                autocomplete="current-password" placeholder="Masukkan Password">
              <label for="floatingInput">Password</label>
              @error('password')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror

            </div>

            <div class="mb-3 text-start">
              <div class="d-row d-flex justify-content-center">
                <div class="form-check pt-1">
                  <input class="form-check-input shadow" type="checkbox" name="remember" id="remember"
                    value="{{ old('remember') ? 'checked' : '' }}">

                  <label class="form-check-label" for="remember">
                    {{ __('Remember Me') }}
                  </label>
                </div>

                @if (Route::has('password.request'))
                <a class="btn btn-link fst-italic ms-auto" href="{{ route('password.request') }}"
                  style="font-size: small;">
                  {{ __('Forgot Your Password?') }}
                </a>
                @endif
              </div>


            </div>

            <div class="mb-2 text-center">

              <button type="submit" class="btn px-5 py-2 fw-bold" style="background-color: #020202; color:white">
                {{ __('Login') }}
              </button>

            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection