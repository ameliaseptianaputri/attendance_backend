<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\HasApiTokens;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Ambil kredensial dari request
        $credentials = $request->only('email', 'password');

        // Log kredensial untuk debugging (hapus log ini di produksi)
        Log::info('Login Attempt:', ['email' => $credentials['email'], 'password' => $credentials['password']]);

        // Cek kredensial dan autentikasi
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Buat token personal access
            $token = $user->createToken('Personal Access Token')->plainTextToken;

            // Kembalikan response dengan token dan data pengguna
            return response()->json([
                'token' => $token,
                'user' => $user
            ], 200);
        } else {
            // Jika kredensial salah, kembalikan response error
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            // Revoke all tokens...
            $user->tokens->each(function ($token, $key) {
                $token->delete();
            });
            return response()->json(['message' => 'Successfully logged out']);
        } else {
            return response()->json(['error' => 'An error occurred while logging out.'], 500);
        }
    }



    public function register(Request $request)
    {
        try {
            Log::info('Registration Request: ', $request->all()); // Logging for debugging

            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'role' => 'user',
                'telp' => 'required|string|max:15',
                'tempat_lahir' => 'required|string|max:255',
                'tanggal_lahir' => 'required|date',
                'jenis_kelamin' => 'required|in:Perempuan,Laki_laki',
                'status' => 'required|string|max:255',
                'jurusan' => 'required|string|max:255',
                'sekolah' => 'required|string|max:255',
                'agama' => 'required|string|max:255',
                'alamat' => 'required|string|max:500',
            ]);

            Log::info('Validated Data: ', $validatedData); // Logging validated data for debugging

            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'role' => 'user',
                'telp' => $validatedData['telp'],
                'tempat_lahir' => $validatedData['tempat_lahir'],
                'tanggal_lahir' => $validatedData['tanggal_lahir'],
                'jenis_kelamin' => $validatedData['jenis_kelamin'],
                'status' => $validatedData['status'],
                'jurusan' => $validatedData['jurusan'],
                'sekolah' => $validatedData['sekolah'],
                'agama' => $validatedData['agama'],
                'alamat' => $validatedData['alamat'],
            ]);

            return response()->json(['success' => true, 'message' => 'Registration successful']);
        } catch (\Exception $e) {
            Log::error('Registration Error: ' . $e->getMessage()); // Log the error message for debugging
            return response()->json(['success' => false, 'message' => 'Registration failed', 'error' => $e->getMessage()], 500);
        }
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['message' => 'Password changed successfully']);
    }

    public function verifyPassword(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ]);

        $user = auth()->user();

        if ($user && Hash::check($request->password, $user->password)) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'message' => 'Incorrect password.'], 401);
        }
    }
}
