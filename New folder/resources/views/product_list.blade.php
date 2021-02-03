@extends('layouts.app')

@section('content')
<script>
</script>
<div class="container">
    <div class="row">
        <div class="box">
            <div style="padding-bottom: 15px" class="row">
                <h3 class="text-center">Games</h3>
                <br>
                <div class="col-md-12">
                    <form action="{{ route('search_product') }}" method="POST" style="margin-right: 10px;margin-left: 10px">
                        {{ csrf_field() }}
                        <div class="input-group">
                            <input type="text" name="search_string" id="search_string" placeholder="Search"
                                class="form-control">
                            <div class="input-group-btn">
                                <input type="submit" name="search_button" id="search_button" value="Search" class="btn btn-primary">
                            </div>
                        </div>
                    </form>
                    <div style="margin-left: -5px; margin-top: 10px; margin-right: -5px" class="row">
                        <div class="col-md-2">
                            <select style="width: 100%" id="typeID">
                                <option value="">Select Type</option>
                                <option value="1">Currency</option>
                                <option value="2">Item & Skin</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select style="width: 100%" id="gameID">
                                <option value="">Select Games</option>
                                @foreach($categori as $c)
                                    <option value="{{$c->id}}">{{$c->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="button" class="btn btn-primary btn-xs" id="sort" value="Sort Rating">
                        </div>
                        <div class="col-md-6 text-right">
                            <button class="btn btn-primary btn-xs" id="findBtn">Find</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="box">
            <div class="box-header">
                <h3>Products</h3>
            </div>
            <div class="box-body">
                @foreach ($products as $product)
                    <div id="productData" class="col-md-12">
                        <div class="box">
                            <div class="box-body">
                                <div class="text-center">
                                    <div style="padding-top: 10px" class="col-md-4 text-center">
                                        <p><a href="{{url('/image/'.$product->image)}}" ><img src="{{url('/image/'.$product->image)}}" style="height: 200px"  alt="Product Image"></a></p>
                                    </div>
                                    <div style="margin: auto" class="col-md-5">
                                        <h4 style="padding-top: 0" class="text-left">Name: {{ $product->name }}</h4>
                                        <p class="text-left">Price: {{ $product->price }}</p>
                                        <p  class="text-left">Category: {{ $product->cate }}</p>

                                    </div>
                                    <div class="col-md-3">
                                        <?php
                                        $temp = 0;
                                        $rate = 0;
                                        foreach ($rating as $r){
                                            if($r->product_id == $product->id){
                                                $rate += $r->rating;
                                                $temp += 1;
                                            }
                                        }
                                        if($rate == 0){
                                            $ratetotal = 0;
                                        }else{
                                            $ratetotal = $rate / $temp;
                                        }

                                        ?>
                                        <div class="row text-center">
                                            <h1>{{number_format($product->rate,1,'.',',')}}</h1>
                                        </div>
                                        <div class="row text-center">
                                            @if($product->rate > 4.5)
                                                <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                            @elseif($product->rate > 4)
                                                <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                <img height="30px" src="{{url('/rating/Star-Half-Full.png')}}">
                                            @elseif($product->rate > 3.5)
                                                <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                            @elseif($product->rate > 3)
                                                <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                <img height="30px" src="{{url('/rating/Star-Half-Full.png')}}">
                                                <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                            @elseif($product->rate > 2.5)
                                                <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                                <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                            @elseif($product->rate > 2)
                                                <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                <img height="30px" src="{{url('/rating/Star-Half-Full.png')}}">
                                                <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                                <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                            @elseif($product->rate > 1.5)
                                                <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                                <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                                <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                            @elseif($product->rate > 1)
                                                <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                <img height="30px" src="{{url('/rating/Star-Half-Full.png')}}">
                                                <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                                <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                                <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                            @elseif($product->rate > 0.5)
                                                <img height="30px" src="{{url('/rating/Star-Full.png')}}">
                                                <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                                <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                                <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                                <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                            @elseif($product->rate > 0)
                                                <img height="30px" src="{{url('/rating/Star-Half-Full.png')}}">
                                                <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                                <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                                <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                                <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                            @elseif($product->rate == 0)
                                                <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                                <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                                <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                                <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                                <img height="30px" src="{{url('/rating/star-kosong.jpg')}}">
                                            @endif
                                            <p>Seller: {{ $product->nama }}</p>
                                        </div>
                                        <div class="row">
                                            @if($product->vip ==1)
                                                <h2 class="text text-warning">VIP</h2>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="box-footer">
                                <div class="col-md-6 text-right">
                                    <a href="/view_detail/{{$product->id}}"><button type="submit" class="btn btn-primary">View Detail</button></a>
                                </div>
                                <div  class="col-md-6 text-left">
                                    <a href="/add_chat/{{$product->id}}"><button type="submit" class="btn btn-primary">Chat</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>

    $(document).ready(function () {
        $("#findBtn").click(function () {
            var type = $("#typeID").val();
            var game = $("#gameID").val();
            {{--$.ajax({--}}
                {{--type: 'get',--}}
                {{--dataType: 'html',--}}
                {{--url: '{{route('product_sort')}}',--}}
                {{--data: 'type_id='+type + '&game=' + game,--}}
                {{--success:function (response) {--}}
                    {{--alert('lalal');--}}
                    {{--console.log(response);--}}
                    {{--$('#productData').html(response);--}}
                {{--}--}}
            {{--});--}}
            window.location.href = '{{route('product_sort')}}' + '/?type=' + type + '&game=' + game;
        });

        $("#sort").click(function () {
            var asc = '{{$asc}}';
            var id = asc != '1' ? 1 : 2;

            window.location.href = '{{route('rating_sort_product')}}' + '/?asc=' + id ;
        });
    });

</script>

<div class="text-center">{{ $products->links() }}</div>

@endsection