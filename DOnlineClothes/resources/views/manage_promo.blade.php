@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <h3 class="text-center">Manage Promo</h3>
        <br>
        <div class="text-center">
            <a href="{{ route('add_promo_page') }}" class="btn btn-primary">Insert New Promo</a>
        </div>
        <br>
        <div class="col-md-12">
            <table class="table table-hover">
                <thead>
                    <th>Promo Code</th>
                    <th>Promo Name</th>
                    <th>Promo Discount</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Action</th>
                </thead>
                
                @foreach ($promoes as $promo)
                <tbody>
                    <td>{{ $promo->code }}</td>
                    <td>{{ $promo->name }}</td>
                    <td>{{ $promo->promo_discount }}</td>
                    <td>{{ $promo->start_date }}</td>
                    <td>{{ $promo->end_date }}</td>
                    <td>
                        <a href="{{ route('edit_promo', $promo) }}" class="btn btn-primary">Edit</a>
                    </td>
                    <td>
                        <form action="{{ route('delete_promo', $promo) }}" method="POST">
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