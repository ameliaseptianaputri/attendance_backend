@extends('adminlte::page')

@section('content')
    <div class="jumbotron py-3 px-4 bg-light text-center">
        <h4 class="display-4 text-dark">
            <b>About</b> <i>{{ $user->name }}</i>
        </h4>
        <hr class="my-4">
        <div class="text-left">
            <h1 class="mb-4">Attendance</h1>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>No</th>
                            <th>Attendance IN</th>
                            <th>Attendance OUT</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @foreach ($attendance as $item)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $item->in }}</td>
                                <td>{{ $item->out }}</td>
                                <td>{{ $item->status }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <hr class="my-4">
            <h1>To Do List</h1>
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="card-body">
                @if (is_countable($todos) && count($todos) > 0)
                    @foreach ($todos as $date => $tasks)
                        @php
                            $formattedDate = date('d M Y', strtotime($date));
                        @endphp
                        <div class="mb-4">
                            <h4>{{ $formattedDate }}</h4>
                            <table class="table table-bordered">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>Content</th>
                                        <th>Keterangan</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                        <th>Catatan untuk siswa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tasks as $todo)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $todo->content }}</td>
                                            <td>{{ $todo->keterangan }}</td>
                                            <td>
                                                @if ($todo->status == 'Completed')
                                                    <span class="badge badge-success">{{ $todo->status }}</span>
                                                @elseif ($todo->status == 'Pending')
                                                    <span class="badge badge-warning">{{ $todo->status }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <form action="{{ route('user.updateStatus', $todo->id) }}" method="POST" id="updateStatusForm{{ $todo->id }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" name="status" onchange="this.form.submit()" {{ $todo->status == 'Completed' ? 'checked' : '' }}>
                                                        <label class="form-check-label">{{ $todo->status }}</label>
                                                    </div>
                                                </form>
                                            </td>
                                            <td>
                                                <form action="{{ route('user.pesan', $todo->id) }}" method="POST">
                                                    @csrf
                                                    <div class="input-group">
                                                        <input type="text" name="pesan" class="form-control" placeholder="Tambahkan pesan...">
                                                        <div class="input-group-append">
                                                            <button type="submit" class="btn btn-info btn-sm">Kirim Pesan ke Index</button>
                                                        </div>
                                                    </div>
                                                </form>
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
