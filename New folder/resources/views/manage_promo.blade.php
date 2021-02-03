@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="box">
            <div class="box-header">
                <h3 class="text-center">Manage Promo</h3>
            </div>
            <div class="box-body">
                <div style="padding-bottom: 20px;margin-left: 15px" class="text-left">
                    <a href="{{ route('add_promo_page') }}" class="btn btn-primary">Insert New Promo</a>
                </div>
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
                                <div style="padding: 0" class="col-md-3">
                                    <a href="{{ route('edit_promo', $promo) }}" class="btn btn-primary">Edit</a>
                                </div>
                                <div style="padding: 0" class="col-md-9">
                                    <form action="{{ route('delete_promo', $promo) }}" method="POST">
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
@endsection