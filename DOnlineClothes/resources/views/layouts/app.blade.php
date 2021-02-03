<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>D'Online Clothes</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        .navbar-nav > li > a {
            font-size: 0.9em;
        }
    </style>
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse"
                        aria-expanded="false">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        D'Online Clothes
                    </a>

                    @if (Auth::user()['role'] == 'Member')
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="{{ route('cart') }}">Cart</a>
                        </li>
                        <li>
                            <a href="{{ route('my_profile') }}">Profile</a>
                        </li>
                        <li>
                            <a href="{{ route('product_list') }}">Clothes</a>
                        </li>
                    </ul>
                    @elseif (Auth::user()['role'] == 'Admin')
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="{{ route('manage_user') }}">Manage User</a>
                        </li>
                        <li>
                            <a href="{{ route('manage_category') }}">Manage Category</a>
                        </li>
                        <li>
                            <a href="{{ route('manage_product') }}">Manage Clothes</a>
                        </li>
                        <li>
                            <a href="{{ route('manage_promo') }}">Manage Promo</a>
                        </li>
                        <li>
                            <a href="{{ route('transaction_list') }}">Transaction List</a>
                        </li>
                    </ul>
                    @endif
                </div>
                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        <li><a href="#" id="current_date"></a></li>
                        @guest
                        <li><a href="{{ route('login') }}">Login</a></li>
                        <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"
                                aria-haspopup="true" v-pre>
                                Hello, {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu">
                                <li>
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <script>
        function currentDate() {
            var date = new Date();
            date = date.toLocaleString();

            document.getElementById('current_date').innerHTML = date;
            setTimeout(currentDate, 1000);
        }
        currentDate();
    </script>
</body>

</html>