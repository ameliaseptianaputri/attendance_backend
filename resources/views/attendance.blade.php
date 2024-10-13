@extends('adminlte::page')

@section('content')
    <div class="container mt-4">
        <div class="jumbotron py-2 px-1 bg-light text-center mb-4">
            <h1 class="text-dark">Attendance</h1>
        </div>

        @php
            $todayAttendance = $attendance->where('created_at', '>=', \Carbon\Carbon::today())->first();
        @endphp

        @if (auth()->user()->role != 'admin')  {{-- Tampilkan form jika bukan admin --}}
            <div class="d-flex justify-content-center mb-4">
                <form action="{{ !$todayAttendance ? route('store') : route('update', $todayAttendance->id) }}" method="POST" class="card p-5 shadow border-0" style="width: 50%;">
                    @csrf
                    @if ($todayAttendance)
                        @method('PATCH')
                        <input type="hidden" name="out" id="outField">
                        <button type="submit" class="btn btn-danger mt-3" id="attendanceButton">Attendance OUT</button>
                    @else
                        <input type="hidden" name="in" id="inField">
                        <button type="submit" class="btn btn-primary mt-3" id="attendanceButton">Attendance IN</button>
                    @endif
                </form>
            </div>
        @endif

        {{-- Tampilkan tombol ekspor hanya jika pengguna bukan admin --}}
        @if (auth()->user()->role != 'admin')
            <a href="{{ route('word.attendance') }}" class="btn btn-primary mt-3">Expor Jurnal Kehadiran</a>
        @endif

        <div class="table-responsive mt-4">
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Attendance IN</th>
                        <th scope="col">Attendance OUT</th>
                        <th scope="col">Status Now</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach ($attendance as $item)
                        <tr>
                            <th scope="row">{{ $no++ }}</th>
                            <td>{{ $item->in }}</td>
                            <td>{{ $item->out }}</td>
                            <td>{{ $item->status }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('js')
    @if (auth()->user()->role != 'admin')  {{-- JavaScript hanya untuk pengguna non-admin --}}
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const attendanceButton = document.getElementById('attendanceButton');
                const inField = document.getElementById('inField');
                const outField = document.getElementById('outField');
                const todayAttendance = @json($todayAttendance);

                attendanceButton.addEventListener('click', function () {
                    if (todayAttendance === null || todayAttendance.in === null) {
                        inField.value = new Date().toISOString();
                    } else if (todayAttendance.out === null) {
                        outField.value = new Date().toISOString();
                    } else {
                        attendanceButton.disabled = true;
                    }
                });

                if (todayAttendance !== null && todayAttendance.out !== null) {
                    attendanceButton.disabled = true;
                }
            });
        </script>
    @endif
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
