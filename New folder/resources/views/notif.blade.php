@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="box">
                <div class="box-header">
                    <h2>Notification</h2>
                </div>
                <div class="box-body">
                    <div class="row">
                        @foreach($notiff as $n)
                            <div style="width: 97%;margin: auto" class="box">
                                <div class="box-header">
                                    @foreach($user as $u)
                                        @if($n->buyer_id == \Illuminate\Support\Facades\Auth::user()['id'])
                                            @if($n->seller_id == $u->id)
                                                <h3 style="margin-left: 15px">{{$n->name}}</h3>
                                            @endif
                                        @elseif($n->seller_id == \Illuminate\Support\Facades\Auth::user()['id'])
                                            @if($n->buyer_id == $u->id)
                                                <h3 style="margin-left: 15px">{{$u->name}}</h3>
                                            @endif
                                        @endif
                                    @endforeach
                                </div>
                                <div class="box-body">
                                    <div class="col-md-4">
                                        @if($n->active == 2 && \Illuminate\Support\Facades\Auth::user()['id'] == 2)
                                            <img src="{{url('/image/'.$n->bukti)}}" height="160px">
                                        @else
                                            <img src="{{url('/image/'.$n->image)}}" height="160px">
                                        @endif
                                    </div>
                                    <div class="col-md-8">
                                        @if($n->seller_id == \Illuminate\Support\Facades\Auth::user()['id'])
                                            <p style="font-size: 25px">Nama   : {{$n->name}}</p>
                                        @endif
                                        <p style="font-size: 25px">Harga  : {{$n->total_amount_plus_fee}}</p>
                                        @foreach($quantity as $q)
                                            @if($n->transaction_id == $q->transaction_id && $n->product_id == $q->product_id)
                                                <p style="font-size: 25px">Jumlah : {{$q->quantity}}</p>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                <div class="box-footer text-right">
                                    @if($n->active == \Illuminate\Support\Facades\Auth::user()['id'] && $n->seller_id == \Illuminate\Support\Facades\Auth::user()['id']&& $n->struktur == 3)
                                        <form action="/finish_notif/{{$n->id}}/{{$n->buyer_id}}" method="POST">
                                            {{ csrf_field() }}
                                            <button class="btn btn-primary">Selesaikan</button>
                                        </form>
                                    @elseif($n->active == \Illuminate\Support\Facades\Auth::user()['id'] && $n->buyer_id == \Illuminate\Support\Facades\Auth::user()['id'] && $n->struktur == 4)
                                        <a href="/ulasan/{{$n->product_id}}">
                                            <button class="btn btn-primary">Ulasan & Rating</button>
                                        </a>
                                    @elseif($n->active == \Illuminate\Support\Facades\Auth::user()['id'] && $n->buyer_id == \Illuminate\Support\Facades\Auth::user()['id'] && $n->struktur == 1)
                                        <form class="form-horizontal" method="POST" action="{{ route('bukti' , $n->id) }}" enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <label class="pull-left">Post Payment : </label><input type="file" name="image" id="image">
                                            <button class="btn btn-primary">Post</button>
                                        </form>
                                    @elseif($n->struktur == 2  && $n->active == \Illuminate\Support\Facades\Auth::user()['id'])
                                        <form action="/process/{{$n->id}}/{{$n->seller_id}}" method="POST">
                                            {{ csrf_field() }}
                                            <button class="btn btn-primary">Process to Seller</button>
                                        </form>
                                    @elseif($n->active != \Illuminate\Support\Facades\Auth::user()['id'] && $n->active != 0)
                                        <h3>On Process</h3>
                                    @else
                                        <h3>Selesai</h3>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection