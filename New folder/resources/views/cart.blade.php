@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="box">
            <div class="box-header">
                <h3 class="text-center">Cart</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    @if (!empty($cart))
                        <div style="padding-right: 0" class="col-md-8">
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
                                <td><img src="{{ url('/image/'.$item['image']) }}" width="150px" alt="Product Image"></td>
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
                        </div>
                        <div style="padding-left: 0" class="col-md-4">
                            <form action="{{ route('checkout') }}" method="POST">
                            {{ csrf_field() }}

                            <div class="col-md-12">
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

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="code" class="control-label">Total Amount: </label>
                                    <p>IDR {{ $cart['total_amount'] }}</p>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">
                                        Checkout
                                    </button>
                                </div>
                            </div>
                        </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection