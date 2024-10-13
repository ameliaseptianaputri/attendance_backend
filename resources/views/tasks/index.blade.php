@extends('adminlte::page')

@section('content')
    <div class="container mt-4">
        <div class="jumbotron py-2 px-1 bg-light text-center mb-4">
            <h1 class="text-dark">Daftar Tugas</h1>
        </div>

        @if (auth()->user()->role == 'admin')
            <a href="{{ route('tasks.create') }}" class="btn btn-primary mb-3">Buat Tugas Baru</a>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>Task</th>
                        <th>Description</th>

                        @if (auth()->user()->role == 'admin')
                            <th>Assigned To</th>
                        @endif

                        <th>File</th>
                        <th>Created At</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $task)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $task->title }}</td>
                            <td>{{ $task->description }}</td>

                            @if (auth()->user()->role == 'admin')
                                <td>{{ $task->user->name }}</td>
                            @endif

                            <td>
                                @if ($task->file_path)
                                    @php
                                        $extension = pathinfo($task->file_path, PATHINFO_EXTENSION);
                                    @endphp

                                    @if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif']))
                                        <img src="{{ Storage::url($task->file_path) }}" alt="{{ $task->title }}"
                                            class="img-fluid rounded" width="100">
                                    @elseif (in_array($extension, ['pdf', 'doc', 'docx']))
                                        <a href="{{ Storage::url($task->file_path) }}" target="_blank"
                                            class="btn btn-info btn-sm">Lihat File</a>
                                    @else
                                        File tidak dikenali
                                    @endif
                                @else
                                    Tidak ada file
                                @endif
                            </td>

                            <td>{{ $task->created_at->timezone('Asia/Jakarta')->format('d M Y H:i') }}</td>
                            <td>
                                @if ($task->status == 'unread')
                                    <span class="badge bg-warning">Belum dibaca</span>
                                @else
                                    <span class="badge bg-success">Sudah dibaca</span>
                                @endif
                            </td>

                            <td>
                                @if (auth()->user()->role == 'admin')
                                    <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('tasks.destroy', $task) }}" method="POST"
                                        class="d-inline-block"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus tugas ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                @else
                                    <form action="{{ route('tasks.markAsRead', $task) }}" method="POST"
                                        class="d-inline-block">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">Tandai sebagai sudah
                                            dibaca</button>
                                    </form>
                                @endif
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
        .jumbotron.py-2.px-1 {
            background-color: #f8f9fa;
            /* Light background */
            border-radius: 5px;
            /* Rounded corners */
            text-align: center;
            /* Center text */
        }

        .table th,
        .table td {
            vertical-align: middle;
            /* Center align text vertically */
        }

        .table thead th {
            background-color: #343a40;
            /* Dark background for the header */
            color: #ffffff;
            /* White text for header */
        }

        .table tbody tr:hover {
            background-color: #f1f1f1;
            /* Light gray on row hover */
        }
    </style>
@endsection
