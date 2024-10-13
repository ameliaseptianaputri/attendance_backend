@extends('adminlte::page')

@section('content')
    <div class="container">
        <h1>Assign a Task</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('tasks.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="title">Task Title:</label>
                <input type="text" name="title" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="description">Task Description:</label>
                <textarea name="description" class="form-control"></textarea>
            </div>

            <div class="form-group">
                <label for="user_id">Assign to User:</label>
                <select name="user_id" class="form-control" required>
                    <option value="">-- Select User --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="file_path">File</label>
                <input type="file" name="file_path" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Assign Task</button>
        </form>
    </div>
@endsection
