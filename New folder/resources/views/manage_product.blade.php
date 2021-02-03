@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="box">
            <div class="box-header">
                <h3 class="text-center">Manage Product</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div style="padding-bottom: 20px;margin-left: 15px" class="text-left">
                    <a href="{{ route('add_product_page') }}" class="btn btn-primary">Add New Product</a>
                </div>
                </div>
                <div class="row">
                    @foreach ($products as $product)
                        <div class="col-md-6">
                            <div style="padding: 0" class="thumbnail">
                                <div class="text-center">
                                    <div style="margin-top: 5px" class="row text-center">
                                        <p><a href="image/{{$product->image}}" ><img src="image/{{$product->image}}" style="height: 90px"  alt="Product Image"></a></p>
                                    </div>
                                    <div style="margin-left: 20px" class="row text-center">
                                        <div class="col-md-6">
                                            <h5 class="text-left">Name: {{ $product->name }}</h5>
                                            <p class="text-left">Category: {{ $product->category->name }}</p>
                                            <p class="text-left">Price: {{ $product->price }}</p>
                                            <p class="text-left">Estimate Pay out per unit: {{ $product->estimate }}</p>
                                            <p class="text-left">Description: {{ $product->description }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            @if($product->type == 2)
                                                <h5 class="text-left">Type: Item & Skin</h5>
                                            @endif
                                            @if($product->type == 1)
                                                <h5 class="text-left">Type: Currency</h5>
                                            @endif
                                            <p class="text-left">Item per unit: {{ $product->stock }}</p>
                                            <p class="text-left">Total Unit: {{ $product->totaunit }}</p>
                                            <p class="text-left">Delivery Guarentee: {{ $product->delivery }}</p>
                                            <p class="text-left">Duration: {{ $product->duration }} Hari</p>
                                        </div>
                                    </div>
                                </div>
                                <div style="padding-bottom: 10px" class="row">
                                    @if (Auth::user()['role'] == 'Admin' || Auth::user()['role'] == 'Member')
                                    <div class="text-right">
                                        <div class="col-md-6">
                                            <a href="{{ route('edit_product', $product) }}" class="btn btn-primary">Edit</a>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <form action="{{ route('delete_product', $product) }}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}

                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                     @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<div class="text-center">{{ $products->links() }}</div>
@endsection