@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="box">
                <form class="form-horizontal" method="POST" action="/chat_add/{{$pro->id}}/{{$pro->user_id}}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="box-header">
                    <h3>Add Chat</h3>
                </div>
                <div class="box-body">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-4">
                                <img height="200px" src="{{url('image/'.$pro->image)}}">
                            </div>
                            <div class="col-md-8">
                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="name">To</label>
                                    <input id="name" type="text" class="form-control" name="name" value="{{ $pro->na}}" readonly="true">

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="name" >Message</label>
                                    <textarea id="name" class="form-control" name="name"></textarea>

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer text-right">
                    <div class="form-group">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">
                                Sent
                            </button>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection