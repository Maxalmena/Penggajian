@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <h3 class="text-center">My Profile</h3>
        <br>
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body text-center">
                    <p>
                        <img src="{{ Storage::url($user->profile_picture) }}" width="150px" alt="My Profile Picture">
                    </p>
                    <p>Fullname: {{ $user->name }}</p>
                    <p>Email Address: {{ $user->email }}</p>
                    <p>Phone Number: {{ $user->phone_number }}</p>
                    <p>Gender: {{ $user->gender }}</p>
                    <p>Address: {{ $user->address }}</p> 
                    <a href="{{ route('edit_my_profile') }}" class="btn btn-primary">Edit My Profile</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection