@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <h3 class="text-center">Manage User</h3>
        <br>
        <div class="col-md-12">
            <table class="table table-hover">
                <thead>
                    <th>Profile Picture</th>
                    <th>Fullname</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Gender</th>
                    <th>Address</th>
                    <th>Action</th>
                </thead>
            
                @foreach ($users as $user)
                <tbody>
                    <td><img src="{{ Storage::url($user->profile_picture) }}" alt="User Profile Picture" width="150px"></td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone_number }}</td>
                    <td>{{ $user->gender }}</td>
                    <td>{{ $user->address }}</td>
                    <td>
                        <a href="{{ route('user_profile', $user) }}" class="btn btn-primary">Update</a>

                        <form action="{{ route('delete_user', $user) }}" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}

                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tbody>
                @endforeach
            </table>
        </div>
    </div>
</div>

<div class="text-center">{{ $users->links() }}</div>
@endsection