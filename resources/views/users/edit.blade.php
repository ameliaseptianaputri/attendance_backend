@extends('adminlte::page')

@section('content')
    <h1>Edit User</h1>

    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('users.form', ['user' => $user])
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
@endsection
