@extends('layouts.admin')

@section('title', 'Edit Course')

@section('content')
<div class="admin-header">
    <div class="page-title">
        <h1>Edit Course</h1>
        <p>Update course details</p>
    </div>
</div>

<form action="{{ route('content-manager.courses.update', $course->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    @include('content-manager.components.form')
</form>
@endsection