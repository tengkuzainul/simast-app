<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => route('home')],
            ['label' => 'Data Pengguna']
        ];

        $users = Cache::remember('cached_users', now()->addMinutes(30), function () {
            return User::all();
        });

        $users->transform(function ($user) {
            $user->last_login_at = $user->last_login_at ? Carbon::parse($user->last_login_at)->diffForHumans() : null;
            return $user;
        });

        $title = "Hapus Data";
        $text = "Anda yakin ingin menghapus?";
        confirmDelete($title, $text);

        return view('user.index', [
            'breadcrumbs' => $breadcrumbs,
            'title' => 'Data Pengguna',
            'users' => $users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.create', [
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => route('home')],
                ['label' => 'Data Pengguna', 'url' => route('user.index')],
                ['label' => 'Tambah']
            ],
            'title' => 'Tambah Pengguna'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'namaPengguna' => 'required|string|max:255',
            'emailPengguna' => 'required|email|unique:users,email',
            'usernamePengguna' => 'required|string|unique:users,username|max:255',
            'levelPengguna' => 'required|in:Owner,Op-Gudang',
            'password' => 'required|string|min:8',
            'konfirmasiPassword' => 'required|string|same:password',
        ]);

        User::create([
            'name' => $request->namaPengguna,
            'email' => $request->emailPengguna,
            'username' => $request->usernamePengguna,
            'role' => $request->levelPengguna,
            'password' => Hash::make($request->password),
        ]);

        Cache::forget('cached_users');

        return redirect()->route('user.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $cachedUser = Cache::remember("user_edit_{$user->id}", now()->addMinutes(30), function () use ($user) {
            return User::find($user->id);
        });

        return view('user.edit', [
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => route('home')],
                ['label' => 'Data Pengguna', 'url' => route('user.index')],
                ['label' => 'Edit Pengguna']
            ],
            'title' => 'Edit Pengguna',
            'user' => $cachedUser,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'namaPengguna' => 'required|string|max:255',
            'emailPengguna' => 'required|email|unique:users,email,' . $user->id,
            'usernamePengguna' => 'required|string|unique:users,username,' . $user->id . '|max:255',
            'levelPengguna' => 'required|in:Owner,Op-Gudang',
            'password' => 'nullable|string|min:8',
            'konfirmasiPassword' => 'nullable|string|same:password',
        ]);

        $user->update([
            'name' => $request->namaPengguna,
            'email' => $request->emailPengguna,
            'username' => $request->usernamePengguna,
            'role' => $request->levelPengguna,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        Cache::forget('cached_users');
        Cache::forget("user_edit_{$user->id}");

        return redirect()->route('user.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('user.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
