@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="box">
            <div class="box-header">
                <h3 class="text-center">Manage Games</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div style="margin-left: 18px;padding-bottom: 20px" class="">
                <a href="{{ route('add_category_page') }}" class="btn btn-primary">Insert New Games</a>
            </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-hover">
                            <thead>
                                <th>Category Name</th>
                                <th>Action</th>
                            </thead>

                            @foreach($categories as $category)
                            <tbody>
                                <td>{{ $category->name }}</td>
                                <td>
                                    <div style="padding: 0" class="col-md-2">
                                        <a href="{{ route('edit_category', $category) }}" class="btn btn-primary">Edit</a>
                                    </div>
                                    <div style="padding: 0" class="col-md-10">
                                        <form action="{{ route('delete_category', $category) }}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}

                                            <button type="submit" class="btn btn-danger">Delete</button>
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
</div>
@endsection