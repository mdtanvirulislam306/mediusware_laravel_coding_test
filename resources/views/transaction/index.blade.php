@extends('layouts.app')

@section('content')
<div class="col-md-10">
    <div class="card">
        <div class="card-header">{{ __('Dashboard') }}</div>

        <div class="card-body" >
            @if (session('successMsg'))
    <div class="alert alert-success">
        {{ session('successMsg') }}
    </div>
@endif

            <div class="card col-12">
                <div class="card-body">
                    <a href="{{route('transaction.add')}}" class="btn btn-outline-primary">New Transaction</a></a>
                    <table class="table table-bordered">
                        <thead>
                            <th>SL</th>
                            <th>Transaction Type</th>
                            <th>Amount</th>
                            <th>Fee</th>
                            <th>Date</th>
                        </thead>
                        <tbody>
                            @foreach ($data as $d)
                            <tr>
                                <td>{{$loop->index+1}}</td>
                                <td class="text-capitalize">{{$d->transaction_type}}</td>
                                <td>{{$d->amount}}</td>
                                <td>{{$d->fee}}</td>
                                <td>{{$d->date}}</td>
                            </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
