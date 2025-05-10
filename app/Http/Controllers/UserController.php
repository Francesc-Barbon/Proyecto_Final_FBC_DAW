<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        return view('user.dashboard', compact('user'));
    }

    public function index()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Acceso no autorizado.');
        }

        $users = User::where('role', '!=', 'admin')->get();
        return view('user.index', compact('users'));
    }

    public function create()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Acceso no autorizado.');
        }

        return view('user.create');
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Acceso no autorizado.');
        }

        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|confirmed',
            'role' => 'required|in:user,admin',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('user.dashboard')->with('success', 'Usuario creado.');
    }

    public function destroy(User $user)
    {
        if ($user->role === 'admin') {
            return back()->with('error', 'No puedes eliminar administradores.');
        }

        $user->delete();
        return back()->with('success', 'Usuario eliminado.');
    }

    public function edit(User $user)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Acceso no autorizado.');
        }

        return view('user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Acceso no autorizado.');
        }

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);

        $user->update($request->only(['name', 'email']));
        return redirect()->route('users.index')->with('success', 'Usuario actualizado.');
    }
}
