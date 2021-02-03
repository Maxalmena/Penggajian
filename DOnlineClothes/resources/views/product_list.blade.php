@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <h3 class="text-center">Clothes</h3>
        <br>
        <div class="text-center">
            <form action="{{ route('search_product') }}" method="POST" style="width: 50%;" class="col-md-offset-3">
                {{ csrf_field() }}
                <div class="input-group">
                    <input type="text" name="search_string" id="search_string" placeholder="Search"
                        class="form-control">
                    <div class="input-group-btn">
                        <input type="submit" name="search_button" id="search_button" value="Search" class="btn btn-primary">
                    </div>
                </div>
            </form>
        </div>
        <br>
        @foreach ($products as $product)
        <div class="col-md-3">
            <div class="thumbnail text-center">
                <p><img src="{{ Storage::url($product->image) }}" width="150px" alt="Product Image"></p>
                <h5>{{ $product->name }}</h5>
                <p>{{ $product->category->name }}</p>
                <p>{{ $product->price }}</p>
                <p>{{ $product->stock }}</p>
                <p>{{ $product->description }}</p>

                @if (Auth::user()['role'] == 'Member')
                <form action="{{ route('add_to_cart', $product) }}" method="POST">
                    {{ csrf_field() }}

                    <button type="submit" class="btn btn-primary">Add to Cart</button>
                </form>
                @elseif (Auth::user()['role'] == 'Admin')
                <a href="{{ route('edit_product', $product) }}" class="btn btn-primary">Edit</a>
                <form action="{{ route('delete_product', $product) }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}

                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>

<div class="text-center">{{ $products->links() }}</div>
@endsection