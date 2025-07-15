@extends('layouts.admin')

@section('title', 'Create New Course')

@section('content')

<style>
    .section-title {
        color: var(--skBlue);
        margin-bottom: 1.5rem;
        font-size: 1.25rem;
        font-weight: 600;
    }
    .episode-form {
        padding: 1rem;
        margin-bottom: 1.5rem;
        background: white;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        & > .form-row {
            margin-bottom: 0;
            & > .form-group {
                & > .form-label {
                    &.episode_id {
                        font-weight: 600;
                        font-size: 1.15em;
                        color: #253f6b;
                    }
                }
                &.fr_remove_episode {
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    width: fit-content;
                    flex: none;
                    & > button {
                        margin-top: 16px;
                    }
                }
            }
        }
    }
    input::placeholder,
    textarea::placeholder,
    select::placeholder {
        color: #888;
        opacity: .3; 
    }
    input:focus::placeholder,
    textarea:focus::placeholder {
        color: #bbb;
    }
    input[disabled],
    input[readonly],
    textarea[disabled],
    textarea[readonly],
    select[disabled] {
        background-color: #f5f5f5;
        color: #999;
        cursor: not-allowed;
        opacity: 0.7;
    }
    input[disabled]:focus,
    input[readonly]:focus,
    textarea[disabled]:focus,
    textarea[readonly]:focus,
    select[disabled]:focus {
        border: none;
    }

    .form-control {
        &.episode-description {
            min-height: auto;
            padding: 0.2rem 1rem;
            resize: both;
        }
    }
</style>

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