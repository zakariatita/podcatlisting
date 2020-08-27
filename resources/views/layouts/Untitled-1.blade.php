<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script type="text/javascript" src="{{ asset('js/app.js') }}">

    </script>
    <title>{{config('app.name','SM-Mobiler')}}</title>
    </head>
    <body>
        <div class="container-fluid">

        <div class=" mb-1">
            <img class="shadow rounded-sm"  src=" {{ asset('1.jpg') }}" width="100%" height="300" >
        </div>

        <nav class=" shadow navbar navbar-expand-lg navbar-dark bg-dark rounded-sm">

            <img src=" {{ asset('logo.webp') }}" alt="Logo" style="width:60px;">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse " id="navbarSupportedContent">
              <ul class="navbar-nav mr-auto ">
                <li class="nav-item ">
                  <a  class="btn btn-outline-secondary m-1 "  href="{{ asset('/') }}">Home</a>
                </li>
                <li class="nav-item">
                  <a class="btn btn-outline-secondary m-1" href="{{ asset('/posts') }}">Posts</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-outline-secondary m-1"  href="{{ asset('/category') }}">Audio Category</a>
                  </li>
                  <li class="nav-item">
                    <a class="btn btn-outline-secondary m-1"href="{{ asset('/contact') }}">Planning</a>
                  </li>
                <li class="nav-item dropdown">
                  <a class="btn btn-outline-secondary dropdown-toggle m-1" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Dropdown
                  </a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ asset('/category') }}">Category</a>

                    <a class="nav-item " href="#">Another action</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Something else here</a>
                  </div>
                </li>
              </ul>
            </div>
          </nav>
    <div class="container">

        @yield('content')
    </div>
</div>

    </body>
</html>
