<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
	public function index()
	{
		$users = User::with('roles')->latest()->paginate(10);
		return view('users.index', compact('users'));
	}

	public function create()
	{
		$roles = Role::all();
		return view('users.create', compact('roles'));
	}

	public function store(Request $request)
	{
		try {
			$validated = $request->validate([
				'name' => ['required', 'string', 'max:255'],
				'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
				'password' => ['required', 'confirmed', Rules\Password::defaults()],
				'role' => ['required', 'exists:roles,id'],
				'is_active' => ['nullable'],
			]);

			$validated['password'] = Hash::make($validated['password']);
			$validated['is_active'] = $request->has('is_active') ? true : false;
			$validated['role'] = $request->role;

			$user = User::create($validated);

			if ($request->has('role')) {
				$user->roles()->attach($request->role);
			}

			return redirect()->route('users.index')->with('success', 'User created successfully');
		} catch (\Exception $e) {
			Log::error('User creation failed', [
				'error' => $e->getMessage(),
				'request' => $request->all()
			]);
			return back()->withInput()->withErrors(['error' => 'Failed to create user: ' . $e->getMessage()]);
		}
	}

	public function edit(User $user)
	{
		$roles = Role::all();
		return view('users.edit', compact('user', 'roles'));
	}

	public function update(Request $request, User $user)
	{
		$validated = $request->validate([
			'name' => ['required', 'string', 'max:255'],
			'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
			'role' => ['required', 'exists:roles,id'],
			'is_active' => ['nullable'],
		]);

		$validated['is_active'] = $request->has('is_active') ? true : false;
		$validated['role'] = $request->role;

		$user->update($validated);

		if ($request->has('role')) {
			$user->roles()->sync($request->role);
		}

		return redirect()->route('users.index')->with('success', 'User updated successfully');
	}

	public function destroy(User $user)
	{
		if ($user->id === auth()->id()) {
			return back()->with('error', 'You cannot delete your own account');
		}

		$user->roles()->detach();
		$user->delete();

		return redirect()->route('users.index')->with('success', 'User deleted successfully');
	}
}