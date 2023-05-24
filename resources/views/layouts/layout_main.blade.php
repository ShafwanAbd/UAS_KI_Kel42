<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- BOOTSTRAP -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
  </script>

  <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">

  <link rel="stylesheet" href="{{ asset('css/css.css') }}">

  <!-- JS Thingy -->
  <script type="text/javascript" src="{{ asset('js/js.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/instascan.min.js') }}"></script>
  <script type="text/javascript" src="{{asset('js/jquery.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/qrcodelib.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/webcodecamjquery.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/printThis.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/dataTables.js')}}"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

  <!-- Font Poppins -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">

  <!-- Font Patua One -->
  <link href="https://fonts.googleapis.com/css2?family=Patua+One&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Catamaran:wght@400&display=swap" rel="stylesheet">


  <title>Document</title>
</head>

<body style="font-family:  'Poppins', sans-serif;">

  <nav class="navbar navbar-expand-md navbar-light shadow-sm">
    <div class="container">
      <div class="left-side">
        <a class="navbar-brand fw-bold" href="{{ url('/') }}" style="color: #020202">
          QRSave
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
          <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Left Side Of Navbar -->
        <!-- <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto">

                        </ul>
                    </div> -->
      </div>
      <div class="right-side ms-auto">

        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav gap-3 fw-bold" style="color: #020202">
          <!-- Authentication Links -->
          @guest
          @if (Route::has('login'))
          <li class="nav-item">
            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
          </li>
          @endif

          @if (Route::has('register'))
          <li class="nav-item">
            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
          </li>
          @endif
          @else
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/dokumen') }}">{{ __('Dokumen') }}</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/dokumen/history') }}">{{ __('Log Aktifitas') }}</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/profile') }}">{{ __('Profile') }}</a>
          </li>
          <li class="nav-item dropdown ms-auto">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
              aria-haspopup="true" aria-expanded="false" v-pre>
              {{ Auth::user()->name }}
            </a>

            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
              </a>

              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
              </form>
            </div>
          </li>
          @endguest
        </ul>
      </div>

    </div>
  </nav>

  <div class="">
    @yield('content')
  </div>

  <!-- CDN DataTables -->
  <!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
  <!-- pake jquery ini gabisa nyala euy cam nya -->
  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
</body>

</html>