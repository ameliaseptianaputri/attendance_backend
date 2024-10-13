@extends('adminlte::page')

@section('content')
    <div class="container mt-4">
        <div class="jumbotron py-2 px-1 bg-light text-center mb-4">
            <h1 class="text-dark">To Do List</h1>
        </div>

        <div class="card">
            <div class="card-header d-flex justify-content-end">
                {{-- Tampilkan tombol tambah hanya jika pengguna bukan admin --}}
                @if (auth()->user()->role != 'admin')
                    <a href="{{ route('ToDoList.create') }}" class="btn btn-primary me-3">Tambah</a>
                @endif
                
                {{-- Tampilkan tombol ekspor hanya jika pengguna bukan admin --}}
                @if (auth()->user()->role != 'admin')
                    <a href="{{ route('word.tdl') }}" class="btn btn-primary me-3">Expor To-do List</a>
                @endif
            </div>

            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if (count($todos) > 0)
                    @foreach ($todos as $date => $tasks)
                        @php
                            $formattedDate = date('D, d M Y', strtotime($date));
                        @endphp
                        <div class="mb-4">
                            <h4>{{ $formattedDate }}</h4>
                            <table class="table table-bordered table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Content</th>
                                        <th>Keterangan</th>
                                        @if (auth()->user()->role == 'admin')
                                            <th>User</th> {{-- New User column for admin --}}
                                        @endif
                                        <th>Status</th>
                                        @if (auth()->user()->role == 'admin')
                                            <th>Beri Catatan</th>
                                            @else
                                            <th>Catatan dari Pembimbing</th>
                                        @endif
                                        @if (auth()->user()->role == 'user')
                                            <th>Action</th> {{-- New User column for admin --}}
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tasks as $todo)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $todo->content }}</td>
                                            <td>{{ $todo->keterangan }}</td>

                                            @if (auth()->user()->role == 'admin')
                                                <td>{{ $todo->user->name }}</td> {{-- Display user's name --}}
                                            @endif

                                            <td>
                                                @if (auth()->user()->role == 'user')
                                                    {{-- Admin can't edit the status, only display it --}}
                                                    <span class="badge {{ $todo->status == 'Completed' ? 'bg-success' : 'bg-warning' }}">
                                                        {{ $todo->status }}
                                                    </span>
                                                @else
                                                    {{-- Regular users can edit the status --}}
                                                    <form action="{{ route('ToDoList.updateStatus', $todo->id) }}" method="POST" id="updateStatusForm{{ $todo->id }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" name="status" onchange="this.form.submit()" {{ $todo->status == 'Completed' ? 'checked' : '' }}>
                                                            <label class="form-check-label">{{ $todo->status }}</label>
                                                        </div>
                                                    </form>
                                                @endif
                                            </td>

                                            <td>
                                                @if (auth()->user()->role == 'admin')
                                                    {{-- Admin can add a note --}}
                                                    <form action="{{ route('ToDoList.addNote', $todo->id) }}" method="POST">
                                                        @csrf
                                                        <div class="input-group">
                                                            <input type="text" name="pesan" value="{{ $todo->pesan }}" class="form-control" placeholder="Beri catatan">
                                                            <button type="submit" class="btn btn-success btn-sm">Simpan</button>
                                                        </div>
                                                    </form>
                                                @else
                                                    {{-- Non-admin users just view the mentor's note --}}
                                                    <span>{{ $todo->pesan ?? 'Tidak ada catatan' }}</span>
                                                @endif
                                            </td>

                                            <td>
                                                @if (auth()->user()->role != 'admin')
                                                    {{-- Only non-admin users can edit or delete --}}
                                                    <a href="{{ route('ToDoList.edit', $todo->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                                    <form action="{{ route('ToDoList.destroy', $todo->id) }}" method="POST" style="display: inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah kamu yakin untuk menghapus ini?')">Delete</button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endforeach
                @else
                    <div class="alert alert-info">Tidak ada data To Do List yang tersedia.</div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('css')
<style>
    .jumbotron.py-2.px-1 {
        background-color: #f8f9fa; /* Light background */
        border-radius: 5px; /* Rounded corners */
        text-align: center; /* Center text */
    }
    .table th, .table td {
        vertical-align: middle; /* Center align text vertically */
    }
    .table thead th {
        background-color: #343a40; /* Dark background for the header */
        color: #ffffff; /* White text for header */
    }
    .table tbody tr:hover {
        background-color: #f1f1f1; /* Light gray on row hover */
    }
</style>
@endsection
