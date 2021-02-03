<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>GamingNesia</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/AdminLTE.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/_all-skins.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/rating.css') }}" rel="stylesheet">

    <script type="text/javascript" src="{{asset('js/jquery-3.4.1.min.js')}}"></script>

    <style>
        .navbar-nav > li > a{
            font-size: 1em;
        }
        .open-button {
            background-color: #555;
            color: white;
            padding: 16px 20px;
            border: none;
            cursor: pointer;
            opacity: 0.8;
            position: fixed;
            bottom: 23px;
            right: 28px;
            width: 280px;
        }

        /* The popup chat - hidden by default */
        .chat-popup {
            display: none;
            position: fixed;
            bottom: 50px;
            right: 50px;
            /*border: 3px solid #f1f1f1;*/
            z-index: 9;
        }

        /* Add styles to the form container */
        .form-container {
            max-width: 300px;
            padding: 10px;
            background-color: white;
        }

        /* Full-width textarea */
        .form-container textarea {
            width: 100%;
            padding: 15px;
            margin: 5px 0 22px 0;
            border: none;
            background: #f1f1f1;
            resize: none;
            min-height: 200px;
        }

        /* When the textarea gets focus, do something */
        .form-container textarea:focus {
            background-color: #ddd;
            outline: none;
        }

        /* Set a style for the submit/send button */
        .form-container .btn {
            background-color: #4CAF50;
            color: white;
            padding: 16px 20px;
            border: none;
            cursor: pointer;
            width: 100%;
            margin-bottom:10px;
            opacity: 0.8;
        }

        /* Add a red background color to the cancel button */
        .form-container .cancel {
            background-color: red;
        }

        /* Add some hover effects to buttons */
        .form-container .btn:hover, .open-button:hover {
            opacity: 1;
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
                        GamingNesia
                    </a>

                    @if (Auth::user()['role'] == 'Member')
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="{{ route('cart') }}">Cart</a>
                        </li>
                        <li>
                            <a href="{{ route('my_profile') }}">Profile</a>
                        </li>
                        {{--<li>--}}
                            {{--<a href="{{ route('product_list') }}">Product</a>--}}
                        {{--</li>--}}
                        <li>
                            <a href="{{ route('manage_product') }}">Manage Product</a>
                        </li>
                        <li>
                            <a href="{{ route('transaction_list') }}">Transaction List</a>
                        </li>
                    </ul>
                    @elseif (Auth::user()['role'] == 'Admin')
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="{{ route('manage_user') }}">Manage User</a>
                        </li>
                        <li>
                            <a href="{{ route('manage_product') }}">Manage Product</a>
                        </li>
                        <li>
                            <a href="{{ route('manage_category') }}">Manage Games</a>
                        </li>
                        <li>
                            <a href="{{ route('manage_promo') }}">Manage Promo</a>
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
                        @if (Auth::user()['role'] == 'Member' || Auth::user()['role'] == 'Admin')
                            <li class="dropdown notifications-menu">
                                <a style="padding: 0" class="dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                    <div style="margin-top: 10px; margin-right: 5px" class="row">
                                        <div style="padding: 0;margin-top: 7px" class="col-md-6">
                                            <i class="fa fa-bell-o"></i>
                                        </div>
                                        <div style="padding: 0;" class="col-md-6">
                                            <span style="margin-top: 10px;padding: 2px 5px 2px 5px" class="label label-warning">{{$notif}}</span>
                                        </div>
                                    </div>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="header">You have {{$notif}} unread notifications</li>

                                    <li>
                                        <ul class="menu">
                                            @foreach($chat as $c)
                                                <li>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <img style="margin-top: 3px; margin-left: 3px; width: 70px" src="{{url('/image/'.$c->image)}}">
                                                        </div>
                                                        <div style="font-size: 12px" class="col-md-9">
                                                            <p>{{$c->name}}</p>
                                                            <p>{{$c->date}}</p>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>

                                    <li class="footer"><a href="{{route('notif')}}">See All Notifications</a></li>
                                </ul>
                            </li>
                        @endif
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
    @if (Auth::user()['role'] == 'Member' || Auth::user()['role'] == 'Admin')
        <button type="submit" onclick="openForm()" id="open" class="open-button" style="position: fixed; bottom: 50px; right: 50px">Chat</button>
        <button type="button" class="btn cancel" style="display: none;position: fixed; bottom: 20px; right: 50px" id="close" onclick="closeForm()">Close</button>
        <div class="chat-popup" id="myForm"></div>
    @endif
    <script>
        function openForm() {
            document.getElementById("myForm").style.display = "block";
            $("#myForm").load('{{route('chat_his')}}');
            $("#close").show();
            $("#open").hide();
        }

        function closeForm() {
            document.getElementById("myForm").style.display = "none";
            $("#close").hide();
            $("#open").show();
        }
    </script>

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