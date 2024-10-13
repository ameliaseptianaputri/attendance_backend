@extends('adminlte::page')

@section('content')
    <div class="container mt-4">
        <div class="jumbotron py-2 px-1 bg-light text-center mb-4">
            <h1 class="text-dark">Users List</h1>
        </div>
        <a href="{{ route('users.create') }}" class="btn btn-primary mb-3">Add New User</a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ ucfirst($user->role) }}</td> {{-- Capitalize the role --}}
                            <td>
                                <a href="{{ route('show.user', $user->id) }}" class="btn btn-primary btn-sm">Show</a>
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('css')
<style>
    /* Custom styles */
    .table th, .table td {
        vertical-align: middle; /* Align text vertically center */
    }
    
    .table thead th {
        background-color: #f8f9fa; /* Light background for header */
        color: #343a40; /* Dark text color */
    }

    .table tbody tr:hover {
        background-color: #f1f1f1; /* Highlight row on hover */
    }
</style>
@endsection
