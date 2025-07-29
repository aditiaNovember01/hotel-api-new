<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserViewController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('user.index', compact('users'));
    }

    public function create()
    {
        return view('user.create');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('user.edit', compact('user'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'phone' => 'nullable|string|max:20',
            'role' => 'nullable|string|max:50',
        ]);

        $data['password'] = bcrypt($data['password']);
        User::create($data);
        return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'role' => 'nullable|string|max:50',
        ]);

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);
        return redirect()->route('user.index')->with('success', 'User berhasil diupdate!');
    }

    public function report()
    {
        $totalUsers = User::count();
        $activeUsers = User::where('role', 'user')->count();
        $adminUsers = User::where('role', 'admin')->count();
        $usersWithBookings = User::has('bookings')->count();
        
        $recentUsers = User::latest()->take(5)->get();
        $topUsers = User::withCount('bookings')
            ->orderBy('bookings_count', 'desc')
            ->take(5)
            ->get();

        return view('user.report', compact(
            'totalUsers', 
            'activeUsers', 
            'adminUsers', 
            'usersWithBookings',
            'recentUsers',
            'topUsers'
        ));
    }
} 