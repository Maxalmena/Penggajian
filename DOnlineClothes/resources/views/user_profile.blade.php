@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <h3 class="text-center">Update User Profile</h3>
        <br>
        <div class="col-md-8 col-md-offset-2">
            <form class="form-horizontal" method="POST" action="{{ route('update_user_profile', $user) }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PUT') }}

                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="name" class="col-md-4 control-label">Fullname</label>

                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control" name="name" value="{{ $user->name }}">

                        @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control" name="email" value="{{ $user->email }}">

                        @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label for="phone_number" class="col-md-4 control-label">Phone Number</label>

                    <div class="col-md-6">
                        <input type="text" class="form-control" name="phone_number" id="phone_number" value="{{ $user->phone_number }}">

                        @if ($errors->has('phone_number'))
                        <span class="help-block">
                            <strong>{{ $errors->first('phone_number') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label for="gender" class="col-md-4 control-label">Gender</label>

                    <div class="col-md-6">
                        <input type="radio" name="gender" id="male_gender" value="Male" {{ ($user->gender == 'Male') ? 'checked' : '' }}> <label for="male_gender">Male</label>
                        <input type="radio" name="gender" id="female_gender" value="Female" {{ ($user->gender == 'Female') ? 'checked' : ''}}> <label for="female_gender">Female</label>

                        @if ($errors->has('gender'))
                        <span class="help-block">
                            <strong>{{ $errors->first('gender') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label for="address" class="col-md-4 control-label">Address</label>

                    <div class="col-md-6">
                        <textarea name="address" id="address" cols="35" rows="5" placeholder="XXX Street">{{ $user->address }}</textarea>

                        @if ($errors->has('address'))
                        <span class="help-block">
                            <strong>{{ $errors->first('address') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label for="profile_picture" class="col-md-4 control-label">Profile Picture</label>

                    <div class="col-md-6">
                        <input type="file" name="profile_picture" id="profile_picture">

                        @if ($errors->has('profile_picture'))
                        <span class="help-block">
                            <strong>{{ $errors->first('profile_picture') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">
                            Update User Profile
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection