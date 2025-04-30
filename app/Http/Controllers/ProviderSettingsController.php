<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProviderSettingsController extends Controller
{
    public function index()
    {
        // Load provider settings data here (e.g., $provider, $services, $notifications, $payment, etc.)
        // For now, just return the view
        return view('provider.settings');
    }

    public function update(Request $request)
    {
        // Handle general settings update
        return redirect()->route('provider.settings')->with('success', 'Paramètres mis à jour !');
    }

    public function updateSecurity(Request $request)
    {
        // Handle security settings update
        return redirect()->route('provider.settings')->with('success', 'Sécurité mise à jour !');
    }

    public function updatePayment(Request $request)
    {
        // Handle payment settings update
        return redirect()->route('provider.settings')->with('success', 'Paiement mis à jour !');
    }

    public function updateEmails(Request $request)
    {
        // Handle email settings update
        return redirect()->route('provider.settings')->with('success', 'Emails mis à jour !');
    }
}