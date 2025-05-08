<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class AdminSettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:Admin']);
    }

    public function index()
    {
        $settings = Setting::all()->keyBy('key');
        return view('admin.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'site_email' => 'required|email|max:255',
            'site_description' => 'nullable|string',
            'timezone' => 'required|string',
            'date_format' => 'required|string',
        ]);
        $this->updateOrCreateSetting('site_name', $request->site_name);
        $this->updateOrCreateSetting('site_email', $request->site_email);
        $this->updateOrCreateSetting('site_description', $request->site_description);
        $this->updateOrCreateSetting('timezone', $request->timezone);
        $this->updateOrCreateSetting('date_format', $request->date_format);
        Cache::forget('settings');
        return redirect()->route('admin.settings')->with('success', 'Paramètres généraux mis à jour avec succès !');
    }

    public function updateSecurity(Request $request)
    {
        $request->validate([
            'password_min_length' => 'required|integer|min:6|max:30',
            'login_attempts_limit' => 'required|integer|min:1|max:10',
        ]);
        $this->updateOrCreateSetting('password_min_length_enabled', $request->has('password_min_length_enabled') ? 1 : 0);
        $this->updateOrCreateSetting('password_min_length', $request->password_min_length);
        $this->updateOrCreateSetting('password_require_special', $request->has('password_require_special') ? 1 : 0);
        $this->updateOrCreateSetting('password_require_numbers', $request->has('password_require_numbers') ? 1 : 0);
        $this->updateOrCreateSetting('login_attempts_limit_enabled', $request->has('login_attempts_limit_enabled') ? 1 : 0);
        $this->updateOrCreateSetting('login_attempts_limit', $request->login_attempts_limit);
        $this->updateOrCreateSetting('enable_recaptcha', $request->has('enable_recaptcha') ? 1 : 0);
        Cache::forget('settings');
        return redirect()->route('admin.settings')->with('success', 'Paramètres de sécurité mis à jour avec succès !');
    }

    public function updatePayment(Request $request)
    {
        $request->validate([
            'platform_fee' => 'required|numeric|min:0|max:100',
            'paypal_client_id' => 'nullable|string',
            'paypal_secret' => 'nullable|string',
            'paypal_mode' => 'required|in:sandbox,live',
        ]);
        $this->updateOrCreateSetting('enable_paypal', $request->has('enable_paypal') ? 1 : 0);
        $this->updateOrCreateSetting('enable_stripe', $request->has('enable_stripe') ? 1 : 0);
        $this->updateOrCreateSetting('platform_fee', $request->platform_fee);
        $this->updateOrCreateSetting('paypal_client_id', $request->paypal_client_id);
        $this->updateOrCreateSetting('paypal_secret', $request->paypal_secret);
        $this->updateOrCreateSetting('paypal_mode', $request->paypal_mode);
        Cache::forget('settings');
        return redirect()->route('admin.settings')->with('success', 'Paramètres de paiement mis à jour avec succès !');
    }

    public function updateEmails(Request $request)
    {
        $request->validate([
            'mail_host' => 'required|string',
            'mail_port' => 'required|integer',
            'mail_username' => 'required|string',
            'mail_password' => 'nullable|string',
            'mail_encryption' => 'required|in:tls,ssl,none',
            'mail_from_address' => 'required|email',
            'mail_from_name' => 'required|string',
        ]);
        $this->updateOrCreateSetting('mail_host', $request->mail_host);
        $this->updateOrCreateSetting('mail_port', $request->mail_port);
        $this->updateOrCreateSetting('mail_username', $request->mail_username);
        if ($request->filled('mail_password')) {
            $this->updateOrCreateSetting('mail_password', $request->mail_password);
        }
        $this->updateOrCreateSetting('mail_encryption', $request->mail_encryption);
        $this->updateOrCreateSetting('mail_from_address', $request->mail_from_address);
        $this->updateOrCreateSetting('mail_from_name', $request->mail_from_name);
        Cache::forget('settings');
        return redirect()->route('admin.settings')->with('success', 'Paramètres d\'emails mis à jour avec succès !');
    }

    private function updateOrCreateSetting($key, $value)
    {
        Setting::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }
}
