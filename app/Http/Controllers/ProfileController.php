<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function showSetupForm()
    {
        $provider = Auth::user();
        if ($provider->is_profile_completed) {
            return redirect()->route('provider.dashboard');
        }
        return view('provider.profile.setup', compact('provider'));
    }

    public function setupProfile(Request $request)
    {
        $request->validate([
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'address' => 'required|string|max:255',
            'business_type' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
        ]);
        $provider = Auth::user();
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('provider-photos', 'public');
            $provider->photo = $path;
        }
        $provider->address = $request->address;
        $provider->business_type = $request->business_type;
        $provider->capacity = $request->capacity;
        $provider->is_profile_completed = true;
        $provider->save();
        return redirect()->route('provider.dashboard')
            ->with('success', 'Votre profil a été mis à jour avec succès.');
    }
} 