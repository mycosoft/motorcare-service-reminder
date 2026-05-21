<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
	public function run(): void
	{
		$adminRole = Role::where('name', 'Admin')->first();

		$admin = User::firstOrCreate(
			['email' => 'admin@example.com'],
			[
				'name' => 'Admin User',
				'password' => Hash::make('password'),
				'role' => User::ROLE_ADMIN,
				'is_active' => true,
			]
		);

		if ($adminRole && !$admin->roles()->where('role_id', $adminRole->id)->exists()) {
			$admin->roles()->attach($adminRole->id);
		}
	}
}