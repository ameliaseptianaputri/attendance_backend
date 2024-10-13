<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    // Tampilkan semua tugas untuk admin
    public function index()
    {
        if (auth()->user()->role == 'admin') {
            // Jika admin, tampilkan semua tugas
            $tasks = Task::with('user')->get();
        } else {
            // Jika bukan admin, hanya tampilkan tugas untuk user yang login
            $tasks = Task::where('user_id', auth()->id())->get();
        }

        return view('tasks.index', compact('tasks'));
    }


    // Form untuk membuat tugas baru
    public function create()
    {
        $users = User::all(); // Ambil semua user untuk ditugaskan
        return view('tasks.create', compact('users'));
    }

    // Menyimpan tugas baru
    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'file_path' => 'nullable|file|mimes:jpg,jpeg,png,gif,pdf,doc,docx|max:2048',
            'user_id' => 'required|exists:users,id',
        ]);

        // Upload file jika ada
        $filePath = null;
        if ($request->hasFile('file_path')) {
            $filePath = $request->file('file_path')->store('tasks', 'public');
        }

        // Buat tugas baru
        Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $filePath,
            'user_id' => $request->user_id,
        ]);

        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil dibuat.');
    }

    public function edit(Task $task)
    {
        $users = User::all(); // Untuk mengubah pengguna yang ditugaskan
        return view('tasks.edit', compact('task', 'users'));
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'file_path' => 'nullable|file|mimes:jpg,jpeg,png,gif,pdf,doc,docx|max:2048',
            'user_id' => 'required|exists:users,id',
        ]);

        // Upload file baru jika ada
        $filePath = $task->file_path; // Simpan file lama jika tidak ada file baru
        if ($request->hasFile('file_path')) {
            if ($task->file_path) {
                Storage::delete('public/' . $task->file_path); // Hapus file lama
            }

            $filePath = $request->file('file_path')->store('tasks', 'public');
        }

        // Update task
        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $filePath,
            'user_id' => $request->user_id,
        ]);

        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil diperbarui.');
    }

    // Ubah status tugas ke 'read'
    public function markAsRead(Task $task)
    {
        $task->update(['status' => 'read']);
        return redirect()->back()->with('success', 'Tugas ditandai sebagai sudah dibaca.');
    }

    public function destroy(Task $task)
    {
        if ($task->file_path) {
            Storage::delete('public/' . $task->file_path); // Hapus file terkait jika ada
        }

        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil dihapus.');
    }
}
