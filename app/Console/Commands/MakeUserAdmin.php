<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class MakeUserAdmin extends Command
{
	protected $signature = 'user:make-admin {email}';
	protected $description = 'Make a user an admin by email';

	public function handle()
	{
		$email = $this->argument('email');
		$user = User::where('email', $email)->first();

		if (!$user) {
			$this->error("User with email {$email} not found!");
			return 1;
		}

		$user->update([
			'role' => User::ROLE_ADMIN,
			'is_active' => true,
		]);

		$this->info("User {$user->name} has been made an admin!");
		return 0;
	}
}