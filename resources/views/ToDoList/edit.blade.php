@extends('adminlte::page')

@section('content')
    <div class="d-block justify-content-between flex-wrap flex-end-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h5 class="h5">Edit Data To Do List</h5>
        <div class="d-flex">
            <h6>Home / Edit To Do List/ <b class="text-primary">Edit Data To Do List</b></h6>
        </div>  
    </div>
    <div class="card">
        <!-- /.card-header -->
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('ToDoList.update', $todolist->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="content">Content</label>
                    <input type="text" name="content" class="form-control" id="content" placeholder="Content" value="{{ $todolist->content }}" required>
                </div>
                <div class="form-group">
                    <label for="keterangan">Keterangan</label>
                    <input type="text" name="keterangan" class="form-control" id="keterangan" placeholder="Keterangan" value="{{ $todolist->keterangan }}" required>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" class="form-control" id="status" required>
                        <option value="Pending" {{ $todolist->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Completed" {{ $todolist->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="date">Date</label>
                    <input type="date" name="date" class="form-control" id="date" value="{{ $todolist->date }}" required>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{{ route('ToDoList.index') }}" class="btn btn-secondary">Back</a>
            </form>
        </div>
        <!-- /.card-body -->
    </div>
@stop