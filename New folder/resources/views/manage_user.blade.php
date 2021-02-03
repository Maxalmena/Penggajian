@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="box">
            <div class="box-header">
                <h3 class="text-center">Manage User</h3>
            </div>
            <div class="box-body">
            <div class="col-md-12">
                <table class="table table-hover">
                    <thead>
                        <th>Profile Picture</th>
                        <th>Fullname</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Gender</th>
                        <th>Address</th>
                        <th>VIP</th>
                        <th>Action</th>
                    </thead>

                    @foreach ($users as $user)
                    <tbody>
                        <td><img src="{{ url('/image/'.$user->profile_picture) }}" alt="User Profile Picture" width="150px"></td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone_number }}</td>
                        <td>{{ $user->gender }}</td>
                        <td>{{ $user->address }}</td>
                        <td>{{$user->vip}}</td>
                        <td>
                            <div style="padding: 5px" class="col-md-4">
                                <a href="{{ route('user_profile', $user) }}" class="btn btn-primary">Update</a>
                            </div>
                            <div style="padding: 5px;" class="col-md-4">
                                <form action="{{ route('delete_user', $user) }}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}

                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                            <div style="padding: 5px;" class="col-md-4">
                                <form action="{{ route('VIP_user', $user->id) }}" method="POST">
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-warning">VIP</button>
                                </form>
                            </div>
                        </td>
                    </tbody>
                    @endforeach
                </table>
            </div>
        </div>
        </div>
    </div>
</div>

<div class="text-center">{{ $users->links() }}</div>
@endsection