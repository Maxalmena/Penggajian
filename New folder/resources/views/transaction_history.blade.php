@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="box">
            <div class="box-header">
                <h3 class="text-center">Transaction History</h3>
            </div>
            <div class="box-body">
                @foreach ($transactions as $transaction)
                    <div class="box">
                        <div class="box-header">
                            <div>
                                <p>Transaction ID: {{ $transaction->id }}</p>
                                <p>User's Name: {{ $transaction->user->name }}</p>
                                <p>Transaction Date: {{ $transaction->transaction_date }}</p>
                            </div>
                        </div>
                        <div class="box-body">
                            <table class="table table-hover">
                                <thead>
                                    <th>Picture</th>
                                    <th>Clothes Name</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                </thead>

                                @foreach ($transaction->detailTransactions()->get() as $detail_transaction)
                                <tbody>
                                    <td><img src="{{url('/image/'.$detail_transaction->product->image) }}" width="100px" alt="Product Image"></td>
                                    <td>{{ $detail_transaction->product->name }}</td>
                                    <td>{{ $detail_transaction->quantity }}</td>
                                    <td>{{ $detail_transaction->product->price }}</td>
                                </tbody>
                                @endforeach
                            </table>
                        </div>
                        <div class="box-footer">
                            <div>
                                <p>Total Price (Before Discount): {{ $transaction->total_amount_before_discount }}</p>
                                <p>Promo: {{ ($transaction->promo != null) ? $transaction->promo->name : '-' }}</p>
                                <p>Discount: {{ ($transaction->promo != null) ? $transaction->promo->name : 0 }}</p>
                                <p>Fee: {{ $transaction->total_amount_plus_fee -  $transaction->total_amount_after_discount }}</p>
                                <p>Total Price (After Discount): {{ $transaction->total_amount_after_discount }}</p>
                                <p>Total Price (After Discount & Plus Fee): {{ $transaction->total_amount_plus_fee }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection