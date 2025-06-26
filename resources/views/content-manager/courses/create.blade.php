@extends('layouts.admin')

@section('title', 'Create New Course')

@section('content')
<div class="admin-header">
    <div class="page-title">
        <h1>Create New Course</h1>
        <p>Add a new course to the system</p>
    </div>
</div>

<form action="{{ route('content-manager.courses.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @include('content-manager.components.form')
</form>
@endsection