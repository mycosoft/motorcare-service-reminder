<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function email()
    {
        return view('settings.email');
    }

    public function sms()
    {
        return view('settings.sms');
    }

    public function notification()
    {
        return view('settings.notification');
    }

    public function general()
    {
        return view('settings.general');
    }

    public function updateEmail(Request $request)
    {
        $validated = $request->validate([
            'smtp_host' => 'required',
            'smtp_port' => 'required|numeric',
            'smtp_username' => 'required',
            'smtp_password' => 'required',
            'mail_from_address' => 'required|email',
            'mail_from_name' => 'required'
        ]);

        foreach ($validated as $key => $value) {
            Setting::set($key, $value);
        }

        return redirect()->back()->with('success', 'Email settings updated successfully');
    }

    public function updateSms(Request $request)
    {
        $validated = $request->validate([
            'sms_provider' => 'required',
            'api_key' => 'required',
            'sender_id' => 'required'
        ]);

        foreach ($validated as $key => $value) {
            Setting::set($key, $value);
        }

        return redirect()->back()->with('success', 'SMS settings updated successfully');
    }

    public function updateNotification(Request $request)
    {
        $validated = $request->validate([
            'reminder_days_before' => 'required|numeric',
            'enable_email_notifications' => 'boolean',
            'enable_sms_notifications' => 'boolean'
        ]);

        foreach ($validated as $key => $value) {
            Setting::set($key, $value);
        }

        return redirect()->back()->with('success', 'Notification settings updated successfully');
    }

    public function updateGeneral(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required',
            'company_address' => 'required',
            'company_phone' => 'required',
            'company_email' => 'required|email'
        ]);

        foreach ($validated as $key => $value) {
            Setting::set($key, $value);
        }

        return redirect()->back()->with('success', 'General settings updated successfully');
    }
}