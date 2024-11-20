<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\Absen;

class AuthController extends Controller
{
    public function signin()
    {
        return view('auth.sign-in');
    }

    public function signup()
    {
        return view('auth.sign-up');
    }

    public function signupUser(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:users,username',
                'password' => 'required|string|min:5',
                'email' => 'required|string|email|max:255|unique:users,email',
            ]);

            $validatedData['password'] = Hash::make($validatedData['password']);

            $user = User::create([
                'id' => Str::uuid(),
                'name' => $validatedData['name'],
                'username' => $validatedData['username'],
                'password' => $validatedData['password'],
                'email' => $validatedData['email'],
            ]);

            if ($user && Auth::attempt($request->only('username', 'password'))) {
                return redirect()->intended('/sign-in')->with('success', 'Registrasi sukses, silahkan verifikasi email');
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function signinUser(Request $request)
    {
        try {
            $request->validate([
                'username' => 'required|min:1',
                'password' => 'required|min:5',
            ]);

            if (Auth::attempt($request->only('username', 'password'))) {
                $request->session()->regenerate();
                return redirect()->intended('/dashboard')->with('success', 'Login Berhasil!');
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function logout()
    {
        try {
            Auth::logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();
            return redirect('/dashboard');
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error logging out.'], 400);
        }
    }

    public function dashboard()
    {
        try {
            if (!Auth::check()) {
                return redirect('/sign-in');
            }

            $user = Auth::user();
            $today = Carbon::now()->addHours(7);
            $hari = $today->locale('id')->isoFormat('dddd');

            $absen = Absen::firstOrNew(
                ['username' => $user->username, 'created_at' => $today->toDateString()],
                ['id' => (string) Str::uuid(), 'name' => $user->name, 'hari' => $hari, 'masuk' => $today, 'keluar' => null]
            );

            if ($absen->status === null) {
                $absen->masuk = $today;
                $absen->save();
            }

            return view('dashboard', compact('user', 'absen'));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
