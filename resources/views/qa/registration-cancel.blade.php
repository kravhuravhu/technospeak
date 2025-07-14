@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Payment Cancelled</div>

                <div class="card-body">
                    <div class="alert alert-warning">
                        <h4>Payment Not Completed</h4>
                        <p>Your registration was not completed. If this was a mistake, you can try again.</p>
                    </div>

                    <a href="{{ url('/') }}" class="btn btn-primary">Return to Home</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection