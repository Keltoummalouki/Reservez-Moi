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
        $categories = Category::whereHas('services', function($query) {
            $query->where('is_available', true);
        })->get();
        return view('client.services', compact('services', 'categories'));
    }

    /**
     * Retourne la liste des services filtrés/triés (AJAX)
     */
    public function ajaxList(Request $request)
    {
        $query = Service::where('is_available', true)
            ->with(['provider', 'category'])
            ->withCount('reservations');

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
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'price-low':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price-high':
                    $query->orderBy('price', 'desc');
                    break;
                case 'newest':
                    $query->orderBy('created_at', 'desc');
                    break;
                default:
                    $query->latest();
            }
        } else {
            $query->latest();
        }
        $services = $query->paginate(9);
        $html = view('client.partials.services_list', compact('services'))->render();
        $pagination = $services->links()->render();
        return response()->json([
            'html' => $html,
            'pagination' => $pagination,
            'count' => $services->count(),
            'total' => $services->total(),
        ]);
    }
}