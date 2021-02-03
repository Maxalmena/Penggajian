@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="box">
                <form class="form-horizontal" method="POST" action="{{ route('add_ulasan',$data->id) }}" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="box-header">
                    <h3 class="text-center">Insert Ulasan & Rating</h3>
                </div>
                    <div style="margin-top: 20px" class="box-body">
                        <div class="col-md-12">
                            <div class="col-md-7">
                                <div class="col-md-6">
                                    <img height="150px" src="{{url('/image/'.$data->image)}}">
                                </div>
                                <div style="padding: 0" class="col-md-6">
                                    <h2 style="margin: 0">{{$data->name}}</h2>
                                    <h2 style="margin-top: 10px;">Rp. {{$data->price}}</h2>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-4 control-label">Ulasan</label>

                                    <div class="col-md-6">
                                        <textarea id="name"  class="form-control" name="name"></textarea>

                                        @if ($errors->has('name'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-4 control-label">Rating</label>

                                    <div class="col-md-6">
                                        <div class="rate">
                                            <input type="radio" id="star5" name="rate" value="5" />
                                            <label for="star5" title="5 Star">5 stars</label>
                                            <input type="radio" id="star4" name="rate" value="4" />
                                            <label for="star4" title="4 Star">4 stars</label>
                                            <input type="radio" id="star3" name="rate" value="3" />
                                            <label for="star3" title="3 Star">3 stars</label>
                                            <input type="radio" id="star2" name="rate" value="2" />
                                            <label for="star2" title="2 Star">2 stars</label>
                                            <input type="radio" id="star1" name="rate" value="1" />
                                            <label for="star1" title="1 Star">1 star</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer text-right">
                        <div class="form-group">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    Insert Ulasan
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection