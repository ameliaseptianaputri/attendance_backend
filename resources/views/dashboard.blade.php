@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid">

        <div class="jumbotron bg-light p-4">
            <h1 class="display-4">Dashboard</h1>
            <p class="lead">Welcome to Web Attendance PT Mitra Global Informatika</p>
            <hr class="my-4">
            <p>Manage your attendance and tasks efficiently with our comprehensive dashboard.</p>
        </div>

        <div class="row">
            @if (auth()->user()->role == 'admin')
                <div class="col-lg-4 col-12 mb-4">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>
                                {{ App\Models\AttendanceModel::whereDate('created_at', now()->format('Y-m-d'))->count() }}
                            </h3>
                            <p>Attendance Today</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-12 mb-4">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ App\Models\User::all()->count() }}</h3>
                            <p>Total Users</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-12 mb-4">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ App\Models\ToDoList::where('status', 'completed')->count() }}</h3>
                            <p>Tasks Completed</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-tasks"></i>
                        </div>
                    </div>
                </div>
            @endif

            @if (auth()->user()->role == 'user')
                <div class="col-lg-4 col-12 mb-4">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ App\Models\ToDoList::where('status', 'completed')->count() }}</h3>
                            <p>Tasks Completed</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-list"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-12 mb-4">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>
                                {{ App\Models\Task::where('user_id', auth()->user()->id)->count() }}
                            </h3>
                            <p>Task</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-tasks"></i>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        console.log('Dashboard loaded!')
    </script>
@stop
