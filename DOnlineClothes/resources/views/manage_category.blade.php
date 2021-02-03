@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <h3 class="text-center">Manage Category</h3>
        <br>
        <div class="text-center">
            <a href="{{ route('add_category_page') }}" class="btn btn-primary">Insert New Category</a>
        </div>
        <br>
        <div class="col-md-12">
            <table class="table table-hover">
                <thead>
                    <th>Category Name</th>
                    <th>Category Gender</th>
                    <th>Category Age</th>
                    <th>Action</th>
                </thead>

                @foreach($categories as $category)
                <tbody>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->category_gender }}</td>
                    <td>{{ $category->category_age }}</td>
                    <td>
                        <a href="{{ route('edit_category', $category) }}" class="btn btn-primary">Edit</a>
                    </td>
                    <td>
                        <form action="{{ route('delete_category', $category) }}" method="POST">
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
@endsection