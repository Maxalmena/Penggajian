@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <h3 class="text-center">Transaction History</h3>
        <br>
        @foreach ($transactions as $transaction)
        <div>
            <p>Transaction ID: {{ $transaction->id }}</p>
            <p>User's Name: {{ $transaction->user->name }}</p>
            <p>Transaction Date: {{ $transaction->transaction_date }}</p>
        </div>
        <table class="table table-hover">
            <thead>
                <th>Picture</th>
                <th>Clothes Name</th>
                <th>Quantity</th>
                <th>Price</th>
            </thead>

            @foreach ($transaction->detailTransactions()->get() as $detail_transaction)
            <tbody>
                <td><img src="{{ Storage::url($detail_transaction->product->image) }}" width="100px" alt="Product Image"></td>
                <td>{{ $detail_transaction->product->name }}</td>
                <td>{{ $detail_transaction->quantity }}</td>
                <td>{{ $detail_transaction->product->price }}</td>
            </tbody>
            @endforeach
        </table>

        <div>
            <p>Total Price (Before Discount): {{ $transaction->total_amount_before_discount }}</p>
            <p>Promo: {{ ($transaction->promo != null) ? $transaction->promo->name : '-' }}</p>
            <p>Discount: {{ ($transaction->promo != null) ? $transaction->promo->name : 0 }}</p>
            <p>Total Price (After Discount): {{ $transaction->total_amount_after_discount }}</p>
        </div>
        @endforeach
    </div>
</div>
@endsection