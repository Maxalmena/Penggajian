<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="">
<head>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/AdminLTE.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/_all-skins.min.css') }}" rel="stylesheet">
    <link href="{{ url('node_modules/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('css/rating.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="box">
                <div class="box-header">
                    <h3>Chat</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div style="background-color: #4b646f;padding: 10px 10px 10px 10px; border-top: 0px;height: 700px" class="box">
                                @foreach ($chatt as $c)
                                    @if($c->active == \Illuminate\Support\Facades\Auth::user()['id'])
                                        <div style="background-color: #cbb956; margin: 0" onclick="show({{$c->id}})" id="warna{{$c->id}}" class="row">
                                            @foreach ($user as $u)
                                                @if($c->user_id == \Illuminate\Support\Facades\Auth::user()['id'])
                                                    @if($c->seller_id == $u->id)
                                                        <div style="padding-left: 0" class="col-md-8">
                                                            <h3 style="margin-left: 15px">{{$u->name}}</h3>
                                                        </div>
                                                        <div style="margin-top: 10px" id="index{{$c->id}}" class="col-md-4 text-right">
                                                            <span style="font-size: 30px;">{{$c->user_active}}</span>
                                                        </div>
                                                    @endif
                                                @else
                                                    @if($c->user_id == $u->id)
                                                        <div style="padding-left: 0" class="col-md-8">
                                                            <h3 style="margin-left: 15px">{{$u->name}}</h3>
                                                        </div>
                                                        <div style="margin-top: 10px" id="index{{$c->id}}" class="col-md-4 text-right">
                                                            <span style="font-size: 30px;">{{$c->seller_active}}</span>
                                                        </div>
                                                    @endif
                                                @endif
                                            @endforeach
                                        </div>
                                    @else
                                        <div style="background-color: white;margin: 0" onclick="show({{$c->id}})" class="row">
                                            @foreach ($user as $u)
                                                @if($c->user_id == \Illuminate\Support\Facades\Auth::user()['id'])
                                                    @if($c->seller_id == $u->id)
                                                        <h3 style="margin-left: 15px">{{$u->name}}</h3>
                                                    @endif
                                                @else
                                                    @if($c->user_id == $u->id)
                                                        <h3 style="margin-left: 15px">{{$u->name}}</h3>
                                                    @endif
                                                @endif
                                            @endforeach
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div style="background-color: #4b646f; padding: 10px 10px 10px 10px;border-top: 0px;height: 700px" id="chat-box" class="box">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function show(id) {
            $("#chat-box").load("/chat_detail/"+id);
            $("#warna" + id).css("background-color", "white");
            $("#index" + id).hide();
        }
    </script>
</body>
</html>
