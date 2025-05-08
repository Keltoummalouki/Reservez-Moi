<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProviderSettingsController extends Controller
{
    public function index()
    {
        return view('provider.settings');
    }

    public function update(Request $request)
    {
        return redirect()->route('provider.settings')->with('success', 'Paramètres mis à jour !');
    }

    public function updateSecurity(Request $request)
    {
        return redirect()->route('provider.settings')->with('success', 'Sécurité mise à jour !');
    }

    public function updatePayment(Request $request)
    {
        return redirect()->route('provider.settings')->with('success', 'Paiement mis à jour !');
    }

    public function updateEmails(Request $request)
    {
        return redirect()->route('provider.settings')->with('success', 'Emails mis à jour !');
    }
}