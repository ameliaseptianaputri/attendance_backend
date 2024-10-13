<?php

namespace App\Http\Controllers;

use App\Models\AttendanceModel;
use App\Models\ToDoList;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'role' => 'required',
            'profile' => 'nullable',
            'telp' => 'nullable',
            'tempat_lahir' => 'nullable',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable',
            'status' => 'nullable',
            'jurusan' => 'nullable',
            'sekolah' => 'nullable',
            'agama' => 'nullable',
            'alamat' => 'nullable',
        ]);

        $validatedData['password'] = bcrypt($validatedData['password']);
        User::create($validatedData);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'nullable|min:6',
            'role' => 'required',
            'profile' => 'nullable',
            'telp' => 'nullable',
            'tempat_lahir' => 'nullable',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable',
            'status' => 'nullable',
            'jurusan' => 'nullable',
            'sekolah' => 'nullable',
            'agama' => 'nullable',
            'alamat' => 'nullable',
        ]);

        if ($request->password) {
            $validatedData['password'] = bcrypt(value: $validatedData['password']);
        }

        $user->update(attributes: $validatedData);

        return redirect()->route(route: 'users.index')->with(key: 'success', value: 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        $attendance = AttendanceModel::where('user_id', $id)->get();
        $todos = ToDoList::orderBy('date')->where('user_id', $id)->get()->groupBy('date');

        return view('users.show', compact('user', 'attendance', 'todos'));
    }
}
