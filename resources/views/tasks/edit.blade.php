@extends('adminlte::page')

@section('content')
<div class="container">
    <h1>Edit Tugas</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('tasks.update', $task) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="title">Judul Tugas</label>
            <input type="text" name="title" class="form-control" id="title" value="{{ $task->title }}" required>
        </div>

        <div class="form-group">
            <label for="description">Deskripsi</label>
            <textarea name="description" class="form-control" id="description" required>{{ $task->description }}</textarea>
        </div>

        <div class="form-group">
            <label for="file_path">Upload File (Opsional)</label>
            @if($task->file_path)
                <p>File saat ini: <a href="{{ Storage::url($task->file_path) }}" target="_blank">Lihat File</a></p>
            @endif
            <input type="file" name="file_path" class="form-control" id="file_path">
        </div>

        <div class="form-group">
            <label for="user_id">Tugaskan ke User</label>
            <select name="user_id" id="user_id" class="form-control" required>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ $task->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Perbarui Tugas</button>
    </form>
</div>
@endsection
