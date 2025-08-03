@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Personal Guide Requests</h1>
    
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Client</th>
                <th>Topic</th>
                <th>Hours</th>
                <th>Status</th>
                <th>Requested At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($requests as $request)
            <tr>
                <td>{{ $request->id }}</td>
                <td>{{ $request->client->name }}</td>
                <td>{{ $request->topic }}</td>
                <td>{{ $request->hours_requested }}</td>
                <td>{{ ucfirst($request->status) }}</td>
                <td>{{ $request->created_at->format('M j, Y') }}</td>
                <td>
                    <a href="{{ route('admin.personal-guide.show', $request->id) }}" class="btn btn-sm btn-primary">View</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection