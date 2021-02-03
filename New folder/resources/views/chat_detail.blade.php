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
    <div style="background-color: white;margin: auto" class="row">
        <h2 style="padding-left: 10px">{{$user->name}}</h2>
    </div>
    <div style="background-color: white;margin: auto;height: 585px;display: block;overflow-y: scroll" id="chat-box" class="row">
        @foreach($detail as $d)
            @if($d->struktur == \Illuminate\Support\Facades\Auth::user()['id'])
                <div style="margin: auto;padding-left: 10px" class="row text-left">
                    <div style="width: 50%" class="box">
                        <div class="box-header">
                            @if($d->product_id == 0)
                                <p>{{$d->chat}}</p>
                            @else
                                <p><img width="150px" src="{{url('/image/'.$d->product_id)}}" alt=""></p>
                                <p>{{$d->chat}}</p>
                            @endif
                        </div>
                        <div class="box-footer text-right">
                            <p>{{$d->date}}</p>
                        </div>
                    </div>
                </div>
            @else
                <div style="margin: auto;padding-left: 52%" class="row text-right">
                    <div style="width: 97%" class="box">
                        <div class="box-header">
                            @if($d->product_id == 0)
                                <p>{{$d->chat}}</p>
                            @else
                                <p><img width="150px" src="{{url('/image/'.$d->product_id)}}" alt=""></p>
                                <p>{{$d->chat}}</p>
                            @endif
                        </div>
                        <div class="box-footer text-right">
                            <p>{{$d->date}}</p>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
    <div style="margin: auto" class="row">
        @if($chat->user_id == \Illuminate\Support\Facades\Auth::user()['id'])
            <?php $tem = $chat->seller_id ?>
        @else
            <?php $tem = $chat->user_id ?>
        @endif
        {{--<form action="/chat_detail/{{$chat->id}}/{{$tem}}" enctype="multipart/form-data" method="post">--}}
            <input type="text" style="width: 92.6%" id="chat" name="chat">
            <button type="button" onclick="insert({{$chat->id}},{{$tem}})" class="btn btn-primary btn-sm">Send</button>
        {{--</form>--}}
    </div>
</body>
<script>
    var box = document.getElementById('chat-box');
    box.scrollTop = box.scrollHeight;
</script>
<script>


    function insert(id,ids) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url : "/chat_detail/"+id+"/"+ids,
            type : "POST",
            data : {
                name : $('#chat').val(),
            },
            cache : false,
            success: function () {
                location.reload();
            }
        });
    }
</script>
</html>