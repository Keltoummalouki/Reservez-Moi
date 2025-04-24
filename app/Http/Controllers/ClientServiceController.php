<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Category;

class ClientServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:Client']);
    }

    public function index(Request $request)
    {
        $query = Service::where('is_available', true)
            ->with(['provider', 'category'])
            ->withCount('reservations')
            ->latest();

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        $services = $query->paginate(9)->appends($request->query());

        // Get categories that have available services
        $categories = Category::whereHas('services', function($query) {
            $query->where('is_available', true);
        })->get();

        return view('client.services', compact('services', 'categories'));
    }
}