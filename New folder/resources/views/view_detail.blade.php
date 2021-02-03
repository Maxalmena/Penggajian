@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="box">
            <form action="{{ route('add_to_cart', $pro->id) }}" method="POST">
                {{ csrf_field() }}
                <div class="box-header">
                <h3>Product Detail</h3>
            </div>
                <div class="box-body">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-5">
                            <img src="{{url('/image/'.$pro->image)}}" height="250px">
                        </div>
                        <div style="padding: 0" class="col-md-4">
                            <div class="row">
                                <h3 style="margin: 0">{{$pro->name}} - {{$pro->cate}}</h3>
                            </div>
                            <div style="margin-top: 10px" class="row">
                                <div style="padding: 0;font-size: 15px" class="col-md-12">
                                    @if ($pro->type == 1)
                                        <p>Currency</p>
                                    @elseif($pro->type == 2)    
                                        <p>Item & Skin</p>
                                    @endif
                                    <p>Price : {{$pro->price}}</p>
                                    <p>Stock Product : {{$pro->totaunit}}</p>
                                    <p>Delivery Guarantee : {{$pro->delivery}}</p>
                                    <p>Jumlah : <input type="number" name="quan" value="1"></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="row text-center">
                                <h1>Rating</h1>
                                <h1>{{number_format($ratetotal,1,'.',',')}}</h1>
                            </div>
                            <div class="row text-center">
                                @if($ratetotal > 4.5)
                                    <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                    <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                    <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                    <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                    <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                @elseif($ratetotal > 4)
                                    <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                    <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                    <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                    <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                    <img height="30px" src="{{url('/rating/Star-Half-Full.png')}}">
                                @elseif($ratetotal > 3.5)
                                    <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                    <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                    <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                    <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                    <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                @elseif($ratetotal > 3)
                                    <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                    <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                    <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                    <img height="30px" src="{{url('/rating/Star-Half-Full.png')}}">
                                    <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                @elseif($ratetotal > 2.5)
                                    <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                    <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                    <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                    <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                    <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                @elseif($ratetotal > 2)
                                    <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                    <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                    <img height="30px" src="{{url('/rating/Star-Half-Full.png')}}">
                                    <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                    <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                @elseif($ratetotal > 1.5)
                                    <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                    <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                    <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                    <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                    <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                @elseif($ratetotal > 1)
                                    <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                    <img height="30px" src="{{url('/rating/Star-Half-Full.png')}}">
                                    <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                    <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                    <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                @elseif($ratetotal > 0.5)
                                    <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                    <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                    <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                    <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                    <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                @elseif($ratetotal > 0)
                                    <img height="30px" src="{{url('/rating/Star-Half-Full.png')}}">
                                    <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                    <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                    <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                    <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                @elseif($ratetotal == 0)
                                    <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                    <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                    <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                    <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                    <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                @endif
                            </div>
                        </div>
                    </div>
                    <div style="font-size: 20px;margin-left: 0;margin-top: 15px" class="row">
                        <div class="tab-v1">
                            <ul class="nav nav-tabs">
                                <li><a href="#description" data-toggle="tab">Description</a></li>
                                <li><a href="#ulasan" data-toggle="tab">Ulasan</a></li>
                            </ul>

                            <div class="tab-content">
                                @if($active == 'sort')
                                    <div class="tab-pane fade in disabled" id="description">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <p style="margin-left: 5px;margin-top: 15px">{{$pro->description}}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade in active" id="ulasan">
                                        <div style="margin-right: 5px ; margin-top: 10px" class="row">
                                            <input  type="button" class="btn btn-primary pull-right" id="sort" value="Sort Rating" >
                                            {{--<input type="button" class="btn btn-primary pull-right" id="sort2" value="Sort Rating2">--}}
                                        </div>
                                        <div class="row">
                                            <div style="margin-left: 15px;margin-top: 10px" class="row">
                                                @if($ulasan != null)
                                                    @foreach($ulasan as $ul)
                                                        <div style="max-width: 97%;" class="box">
                                                            <div style="padding: 0" class="box-header">
                                                                <p style="margin-left: 10px">{{$ul->name}}</p>
                                                            </div>
                                                            <div style="padding: 0" class="box-body">
                                                                <div style="padding: 0" class="col-md-3">
                                                                    <img style="margin-left: 10px;" width="150px" src="{{url('/image/'.$ul->profile_picture)}}">
                                                                </div>
                                                                <div style="padding: 0" class="col-md-6">
                                                                    <p>{{$ul->ulasan}}</p>
                                                                </div>
                                                                <div style="padding: 0" class="col-md-3">
                                                                    @if($ul->rating > 4.5)
                                                                        <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                                        <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                                        <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                                        <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                                        <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                                    @elseif($ul->rating > 4)
                                                                        <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                                        <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                                        <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                                        <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                                        <img height="30px" src="{{url('/rating/Star-Half-Full.png')}}">
                                                                    @elseif($ul->rating > 3.5)
                                                                        <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                                        <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                                        <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                                        <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                                        <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                                                    @elseif($ul->rating > 3)
                                                                        <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                                        <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                                        <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                                        <img height="30px" src="{{url('/rating/Star-Half-Full.png')}}">
                                                                        <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                                                    @elseif($ul->rating > 2.5)
                                                                        <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                                        <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                                        <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                                        <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                                                        <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                                                    @elseif($ul->rating > 2)
                                                                        <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                                        <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                                        <img height="30px" src="{{url('/rating/Star-Half-Full.png')}}">
                                                                        <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                                                        <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                                                    @elseif($ul->rating > 1.5)
                                                                        <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                                        <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                                        <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                                                        <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                                                        <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                                                    @elseif($ul->rating > 1)
                                                                        <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                                        <img height="30px" src="{{url('/rating/Star-Half-Full.png')}}">
                                                                        <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                                                        <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                                                        <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                                                    @elseif($ul->rating > 0.5)
                                                                        <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                                        <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                                                        <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                                                        <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                                                        <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                                                    @elseif($ul->rating > 0)
                                                                        <img height="30px" src="{{url('/rating/Star-Half-Full.png')}}">
                                                                        <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                                                        <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                                                        <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                                                        <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                                                    @elseif($ul->rating == 0)
                                                                        <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                                                        <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                                                        <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                                                        <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                                                        <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div style="padding: 0" class="box-footer text-right">
                                                                <p>{{$ul->date}}</p>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <div style="max-width: 97%;" class="box">
                                                        <div style="padding: 0" class="box-header">
                                                            <p style="margin-left: 10px">Tidak ada Ulasan</p>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @else
                                    <div class="tab-pane fade in active" id="description">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <p style="margin-left: 5px;margin-top: 15px">{{$pro->description}}
                                                </p>
                                            </div>

                                        </div>
                                    </div>
                                @endif

                                <div class="tab-pane fade in disabled" id="ulasan">
                                    <div style="margin-right: 5px ; margin-top: 10px" class="row">
                                        <input type="button" class="btn btn-primary pull-right" id="sort" value="Sort Rating">
                                        {{--<input type="button" class="btn btn-primary pull-right" id="sort2" value="Sort Rating2">--}}
                                    </div>
                                    <div class="row">
                                        <div style="margin-left: 15px;margin-top: 10px" class="row">
                                            @if($ulasan != null)
                                            @foreach($ulasan as $ul)
                                                <div style="max-width: 97%;" class="box">
                                                    <div style="padding: 0" class="box-header">
                                                        <p style="margin-left: 10px">{{$ul->name}}</p>
                                                    </div>
                                                    <div style="padding: 0" class="box-body">
                                                        <div style="padding: 0" class="col-md-3">
                                                            <img style="margin-left: 10px;" width="150px" src="{{url('/image/'.$ul->profile_picture)}}">
                                                        </div>
                                                        <div style="padding: 0" class="col-md-6">
                                                            <p>{{$ul->ulasan}}</p>
                                                        </div>
                                                        <div style="padding: 0" class="col-md-3">
                                                            @if($ul->rating > 4.5)
                                                                <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                                <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                                <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                                <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                                <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                            @elseif($ul->rating > 4)
                                                                <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                                <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                                <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                                <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                                <img height="30px" src="{{url('/rating/Star-Half-Full.png')}}">
                                                            @elseif($ul->rating > 3.5)
                                                                <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                                <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                                <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                                <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                                <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                                            @elseif($ul->rating > 3)
                                                                <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                                <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                                <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                                <img height="30px" src="{{url('/rating/Star-Half-Full.png')}}">
                                                                <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                                            @elseif($ul->rating > 2.5)
                                                                <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                                <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                                <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                                <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                                                <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                                            @elseif($ul->rating > 2)
                                                                <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                                <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                                <img height="30px" src="{{url('/rating/Star-Half-Full.png')}}">
                                                                <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                                                <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                                            @elseif($ul->rating > 1.5)
                                                                <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                                <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                                <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                                                <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                                                <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                                            @elseif($ul->rating > 1)
                                                                <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                                <img height="30px" src="{{url('/rating/Star-Half-Full.png')}}">
                                                                <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                                                <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                                                <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                                            @elseif($ul->rating > 0.5)
                                                                <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                                <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                                                <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                                                <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                                                <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                                            @elseif($ul->rating > 0)
                                                                <img height="30px" src="{{url('/rating/Star-Half-Full.png')}}">
                                                                <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                                                <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                                                <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                                                <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                                            @elseif($ul->rating == 0)
                                                                <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                                                <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                                                <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                                                <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                                                <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div style="padding: 0" class="box-footer text-right">
                                                        <p>{{$ul->date}}</p>
                                                    </div>
                                                </div>
                                            @endforeach
                                            @else
                                                <div style="max-width: 97%;" class="box">
                                                    <div style="padding: 0" class="box-header">
                                                        <p style="margin-left: 10px">Tidak ada Ulasan</p>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                <div class="box-footer">
                <div class="text-right">
                    @if($pro->totaunit != 0)
                        <button type="submit" class="btn btn-primary">Add to Cart</button>
                    @else
                        <button type="submit" class="btn btn-primary" disabled>Add to Cart</button>
                    @endif
                </div>
            </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $("#sort").click(function () {
            var asc = '{{$asc}}';
            var id = asc != '1' ? 1 : 2;

            window.location.href = '{{route('rating_sort')}}' + '/?asc=' + id + '&id={{$pro->id}}';
        });
    });
</script>
@endsection