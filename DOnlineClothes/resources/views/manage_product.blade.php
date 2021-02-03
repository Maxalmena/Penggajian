@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <h3 class="text-center">Manage Clothes</h3>
        <br>
        <div class="text-center">
            <a href="{{ route('add_product_page') }}" class="btn btn-primary">Add New Clothes</a>
        </div>
        <br>
        @foreach ($products as $product)
        <div class="col-md-3">
            <div class="thumbnail">
                <div class="text-center">
                    <p><img src="{{ Storage::url($product->image) }}" width="150px" alt="Product Image"></p>
                    <h5>Name: {{ $product->name }}</h5>
                    <p>Category: {{ $product->category->name }}</p>
                    <p>Price: {{ $product->price }}</p>
                    <p>Stock: {{ $product->stock }}</p>
                    <p>Description: {{ $product->description }}</p>

                    @if (Auth::user()['role'] == 'Admin')
                    <a href="{{ route('edit_product', $product) }}" class="btn btn-primary">Edit</a>
                    <form action="{{ route('delete_product', $product) }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}

                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<div class="text-center">{{ $products->links() }}</div>
@endsection