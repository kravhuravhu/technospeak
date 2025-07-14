@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Payment Issue</div>

                <div class="card-body">
                    <div class="alert alert-danger">
                        <h4>Payment Not Completed</h4>
                        <p>There was an issue processing your payment. Please try again.</p>
                    </div>

                    <a href="{{ url('/') }}" class="btn btn-primary">Return to Home</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection