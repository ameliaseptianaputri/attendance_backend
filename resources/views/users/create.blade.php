@extends('adminlte::page')

@section('content')
    <h1>Create New User</h1>

    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        @include('users.form')
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
@endsection
