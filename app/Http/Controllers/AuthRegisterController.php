<?php

namespace App\Http\Controllers;

use App\Http\Resources\UsersResources;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Contracts\Service\Attribute\Required;

class AuthRegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'string'
        ]);

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => hash::make($request->password),
        ]);

        $user->save();

        return new UsersResources(true, 'User berhasil di daftarkan', [$user->name]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');
        $token = Auth::attempt($credentials);

        if (!$token)
        {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::user();
        return response()->json([
            'user' => $user,
            'authorization' => [
                'token' => $token,
                'bearer' => 'bearer',
            ]
        ]);
    }

    //patch user to be editor
    public function approve_editor(Request $request, $id)
    {
        if (auth()->user()->role !== 'admin') {
            return response()->json(['message' => 'Anda tidak memiliki izin untuk mengubah peran pengguna.'], 403);
        } 

        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Pengguna tidak ditemukan.'], 404);
        }

        // Validasi permintaan
        $request->validate([
            'role' => 'required|in:editor',
        ]);

        $user->update([
            'role' => $request->input('role'),
        ]);

        return response()->json(['message' => 'Peran pengguna berhasil diubah.']);
    }


    public function logout()
    {
        Auth()->logout();
        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }   

    public function refresh()
    {
        return response()->json([
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }
}

