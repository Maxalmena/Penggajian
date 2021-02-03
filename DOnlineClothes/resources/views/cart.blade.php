@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <h3 class="text-center">Cart</h3>
        <br>
        <div class="col-md-12">
        @if (!empty($cart))
            <table class="table table-hover">
                <thead>
                    <th>Picture</th>
                    <th>Clothes Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Action</th>
                </thead>

                @foreach ($cart['products'] as $index => $item)
                <tbody>
                    <td><img src="{{ Storage::url($item['image']) }}" width="150px" alt="Product Image"></td>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item['quantity'] }}</td>
                    <td>IDR {{ $item['price'] }}</td>
                    <td>
                        <form action="{{ route('delete_item_on_cart', $index) }}" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tbody>
                @endforeach
            </table>

            <form action="{{ route('checkout') }}" method="POST">
                {{ csrf_field() }}

                <div class="col-md-offset-8">
                    <div class="form-group{{ $errors->has('code') ? ' has-error': '' }}">
                        <label for="code" class="control-label">Promo Code: </label>
                        <input type="text" name="code" id="code" class="form-control" placeholder="Enter Promo Code">

                        @if ($errors->has('code'))
                        <span class="help-block">
                            <strong>{{ $errors->first('code') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="col-md-offset-8">
                    <div class="form-group">
                        <label for="code" class="control-label">Total Amount: </label>
                        <p>IDR {{ $cart['total_amount'] }}</p>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-offset-8">
                        <button type="submit" class="btn btn-primary">
                            Checkout
                        </button>
                    </div>
                </div>
            </form>
            @endif
        </div>
    </div>
</div>
@endsection