@extends('layouts.app')

@section('content')
<div class="col-md-10">
    <div class="card">
        <div class="card-header">{{ __('Dashboard') }}</div>

        <div class="card-body">
            
            <a href="{{route('transaction')}}" class="btn btn-outline-primary">Transaction list</a>
            <div class="card col-12">
                <div class="card-body">
                    @if (session('errorMsg'))
                    <div class="alert alert-danger">
                        {{ session('errorMsg') }}
                    </div>
                    @endif
                    <form action="{{route('transaction.insert')}}" method="post" class="form col-6">
                    @csrf
                    <div class="mb-3">
                        <input type="number" class="form-control @error('amount') is-invalid @enderror" name='amount' placeholder="Amount">
                        @error('amount')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                      </div>
                      <div class="mb-3">
                        <select class="form-select" aria-label="Default select example" name="transaction_type">
                            <option selected>Transaction Type</option>
                            <option value="deposit">Deposit</option>
                            <option value="withdrawal">Withdrawal</option>
                          </select>
                      </div>
                      <div class="mb-3">
                        <input type="submit" class="btn btn-primary" value="Transaction">
                      </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
