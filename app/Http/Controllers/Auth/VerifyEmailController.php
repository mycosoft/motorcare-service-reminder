<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class VerifyEmailController extends Controller
{
	public function __invoke(EmailVerificationRequest $request)
	{
		$request->fulfill();

		return redirect()->intended(RouteServiceProvider::HOME)
			->with('status', 'Your email has been verified!');
	}
}