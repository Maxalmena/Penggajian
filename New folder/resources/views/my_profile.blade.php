@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="box">
            <div class="box-header">
                <h3 style="margin-left: 15px">My Profile</h3>
            </div>
            <div class="box-body">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-3">
                            <p>
                                <img src="{{ url('/image/'.$user->profile_picture) }}" width="150px" alt="My Profile Picture">
                            </p>
                        </div>
                        <div class="col-md-9">
                            <p>Fullname: {{ $user->name }}</p>
                            <p>Email Address: {{ $user->email }}</p>
                            <p>Phone Number: {{ $user->phone_number }}</p>
                            <p>Gender: {{ $user->gender }}</p>
                            <p>Address: {{ $user->address }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <div class="text-right">
                    <a href="{{ route('edit_my_profile') }}" class="btn btn-primary">Edit My Profile</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection