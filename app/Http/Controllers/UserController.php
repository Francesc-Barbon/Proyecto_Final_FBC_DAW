<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Controlador para la gestión de usuarios del sistema.
     * Administra el alta, edición y eliminación de trabajadores y administradores.
     */
    public function dashboard()
    {
        $authUser = auth()->user();

        if ($authUser->role === 'admin') {
            // Usuarios con datos cargados
            $users = \App\Models\User::with(['workHours', 'stockMovements'])->get();

            $userStats = $users->map(function ($user) {
                $totalHours = $user->workHours->sum('hours');
                $totalCost = $totalHours * $user->hourly_rate;
                $jobCount = $user->workHours->pluck('job_id')->unique()->count();
                $materialsManaged = $user->stockMovements->sum('quantity');

                return [
                    'user' => $user,
                    'totalHours' => $totalHours,
                    'totalCost' => $totalCost,
                    'jobCount' => $jobCount,
                    'materialsManaged' => $materialsManaged,
                ];
            });

            // Totales globales
            $totalLaborCost = $userStats->sum('totalCost');

            $totalMaterialCost = \App\Models\StockMovement::with('material')
                ->get()
                ->sum(function ($movement) {
                    return $movement->quantity * $movement->material->unit_price;
                });

            $totalCompanyCost = $totalLaborCost + $totalMaterialCost;

            return view('user.dashboard', compact('userStats', 'totalLaborCost', 'totalMaterialCost', 'totalCompanyCost'));
        }

        // Usuario normal: solo sus datos
        $totalHours = $authUser->workHours->sum('hours');
        $totalCost = $totalHours * $authUser->hourly_rate;
        $jobCount = $authUser->workHours->pluck('job_id')->unique()->count();
        $materialsManaged = $authUser->stockMovements->sum('quantity');

        return view('user.dashboard', [
            'userStats' => collect([[
                'user' => $authUser,
                'totalHours' => $totalHours,
                'totalCost' => $totalCost,
                'jobCount' => $jobCount,
                'materialsManaged' => $materialsManaged,
            ]]),
        ]);
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
            'hourly_rate' => 'required|numeric|min:0',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'hourly_rate' => $request->hourly_rate,
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
