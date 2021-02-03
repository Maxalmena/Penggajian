@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <h3 class="text-center">Insert Category</h3>
        <br>
        <div class="col-md-12">
            <form class="form-horizontal" method="POST" action="{{ route('add_category') }}" enctype="multipart/form-data">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="name" class="col-md-4 control-label">Category Name</label>

                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}">

                        @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('category_gender') ? ' has-error' : '' }}">
                    <label for="category_gender" class="col-md-4 control-label">Category Gender</label>

                    <div class="col-md-6">
                        <input type="radio" name="category_gender" id="male_gender" value="Male"> <label for="male_gender">Male</label>
                        <input type="radio" name="category_gender" id="female_gender" value="Female"> <label for="female_gender">Female</label>

                        @if ($errors->has('category_gender'))
                        <span class="help-block">
                            <strong>{{ $errors->first('category_gender') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('category_age') ? ' has-error' : '' }}">
                    <label for="category_age" class="col-md-4 control-label">Category Age</label>

                    <div class="col-md-6">
                        <input id="category_age" type="text" class="form-control" name="category_age" value="{{ old('category_age') }}">

                        @if ($errors->has('category_age'))
                        <span class="help-block">
                            <strong>{{ $errors->first('category_age') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">
                            Insert Category
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection