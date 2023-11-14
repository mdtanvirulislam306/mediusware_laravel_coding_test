@extends('layouts.app')

@section('content')

        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body" id="app">
                    <div class="card col-4">
                        <div class="card-body text-capitalize">
                            <h2>Your current balance is: {{ Auth::user()->balance==0?0:Auth::user()->balance}}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
   
@endsection
