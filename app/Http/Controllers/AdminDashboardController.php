<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Service;
use App\Models\Reservation;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:Admin']);
    }

    public function index()
    {
        $serviceProviders = User::whereHas('roles', function ($query) {
            $query->where('name', 'ServiceProvider');
        })->with('services')->get();

        $totalClients = User::whereHas('roles', function ($query) {
            $query->where('name', 'Client');
        })->count();

        $totalServices = Service::count();

        $totalRevenue = Reservation::where('payment_status', 'completed')
            ->sum('amount');

        $recentReservations = Reservation::with(['user', 'service.provider'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'serviceProviders',
            'totalClients',
            'totalServices',
            'totalRevenue',
            'recentReservations'
        ));
    }
}