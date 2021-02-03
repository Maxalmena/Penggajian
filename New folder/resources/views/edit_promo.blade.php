@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <h3 class="text-center">Update Promo</h3>
        <br>
        <div class="col-md-12">
            <form class="form-horizontal" method="POST" action="{{ route('update_promo', $promo) }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PUT') }}

                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="name" class="col-md-4 control-label">Promo Name</label>

                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control" name="name" value="{{ $promo->name }}">

                        @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('code') ? ' has-error' : '' }}">
                    <label for="code" class="col-md-4 control-label">Promo Code</label>

                    <div class="col-md-6">
                        <input id="code" type="text" class="form-control" name="code" value="{{ $promo->code }}">

                        @if ($errors->has('code'))
                        <span class="help-block">
                            <strong>{{ $errors->first('code') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('promo_discount') ? ' has-error' : '' }}">
                    <label for="promo_discount" class="col-md-4 control-label">Promo Discount</label>

                    <div class="col-md-6">
                        <input id="promo_discount" type="text" class="form-control" name="promo_discount" value="{{ $promo->promo_discount }}">

                        @if ($errors->has('promo_discount'))
                        <span class="help-block">
                            <strong>{{ $errors->first('promo_discount') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('end_date') ? ' has-error' : '' }}">
                    <label for="start_date" class="col-md-4 control-label">Start Date</label>

                    <div class="col-md-6">
                        <input id="start_date" type="date" class="form-control" name="start_date" value="{{ $promo->start_date }}">

                        @if ($errors->has('start_date'))
                        <span class="help-block">
                            <strong>{{ $errors->first('start_date') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('end_date') ? ' has-error' : '' }}">
                    <label for="end_date" class="col-md-4 control-label">End Date</label>

                    <div class="col-md-6">
                        <input id="end_date" type="date" class="form-control" name="end_date" value="{{ $promo->end_date }}">

                        @if ($errors->has('end_date'))
                        <span class="help-block">
                            <strong>{{ $errors->first('end_date') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">
                            Update Promo
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection