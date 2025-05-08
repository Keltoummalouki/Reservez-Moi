<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProviderSettingController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('provider.settings', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
        ]);
        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
        unset($data['password']);
        $user->update($data);
        return redirect()->route('provider.settings')->with('success', 'Paramètres mis à jour avec succès.');
    }
} 