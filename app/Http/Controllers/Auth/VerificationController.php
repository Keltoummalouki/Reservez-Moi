<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    public function show(Request $request)
    {
        return $request->user()->hasVerifiedEmail()
            ? redirect($this->redirectPath())
            : view('auth.verify');
    }

    public function verify(Request $request)
    {
        if ($request->route('id') != $request->user()->getKey()) {
            return redirect($this->redirectPath());
        }

        if ($request->user()->hasVerifiedEmail()) {
            return redirect($this->redirectPath());
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return redirect($this->redirectPath())->with('verified', true);
    }

    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect($this->redirectPath());
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('resent', true);
    }

    protected function redirectPath()
    {
        $user = Auth::user();
        $role = $user->roles->first();

        if (!$role) {
            return '/';
        }

        switch ($role->name) {
            case 'Admin':
                return route('admin.dashboard');
            case 'ServiceProvider':
                return route('provider.dashboard');
            case 'Client':
                return route('client.services');
            default:
                return '/';
        }
    }

    protected function verified(Request $request)
    {
        if ($request->user()->hasRole('ServiceProvider')) {
            return redirect()->route('provider.profile.setup');
        }
        return redirect($this->redirectPath())->with('verified', true);
    }
}