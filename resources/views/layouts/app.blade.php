<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- title -->
    @hasSection('title')
    <title>@yield('title') | {{ config('app.name') }}</title>
    @else
    <title>{{ config('app.name') }}</title>
    @endif

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    @if(\Route::is('delete'))
    <script src="{{asset('js/delete.js')}}" defer></script>
    @endif

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('/siteparts/favicon.ico') }}">
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('ログイン') }}</a>
                        </li>
                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('新規登録') }}</a>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{$aftername ?? Auth::user()->name}} <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="/home">
                                    {{ __('マイページ') }}
                                </a>
                                <a class="dropdown-item" href="{{ url('/orderhistory') }}">
                                    <i class="fas fa-arrow-down"></i>購入履歴
                                </a>
                                <a class="dropdown-item" href="{{ url('/stock') }}">
                                   <i class="fas fa-boxes"></i>投稿作品
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('ログアウト') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        <li>
                            <a class="nav-link" href="{{ url('/favorite') }}">
                                <i class="fas fa-heart"></i>
                            </a>
                        </li>
                        <li>
                            <a class="nav-link" href="{{ url('/mycart') }}">
                                <i class="fas fa-cart-arrow-down"></i>
                                @if($count !==0)
                                <span class="circle">
                                    {{$count ??''}}
                                </span>
                                @endif
                            </a>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
        <footer class="footer_design bg-dark">

            @guest
            <p class="nav-item" style="display:inline;">
                <a class="nav-link" href="{{ route('login') }}"
                    style="color:#fefefe; display:inline;">{{ __('ログイン') }}</a>

                @if (Route::has('register'))

                <a class="nav-link" href="{{ route('register') }}"
                    style="color:#fefefe; display:inline;">{{ __('会員登録') }}</a>
            </p>
            @endif

            @endguest
            <br>
            <div style="margin-top:24px;">
                なんでも売ります<br>
                <p style="font-size:2.4em">{{ config('app.name', 'Laravel') }}</p><br>
            </div>
            <div><i class="fas fa-image"></i><i class="fab fa-cc-visa"></i></div>
            <p style="font-size:0.7em;">@copyright @shimizu</p>

        </footer>
    </div>
</body>

<script src="{{ asset('js/main.js') }}" defer></script>
<?php //自作した/js/main.jsを読み込み?>


</html>
