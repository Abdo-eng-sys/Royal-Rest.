<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    public function index(Request $request)
    {
        $query = MenuItem::with('category')->where('is_active', true);

        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->has('featured')) {
            $query->where('is_featured', true);
        }

        if ($request->has('vegetarian')) {
            $query->where('is_vegetarian', true);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $menuItems = $query->orderBy('sort_order')->get();
        return response()->json($menuItems);
    }

    public function show($id)
    {
        $menuItem = MenuItem::with('category')->findOrFail($id);
        return response()->json($menuItem);
    }

    public function featured()
    {
        $items = MenuItem::with('category')
            ->where('is_active', true)
            ->where('is_featured', true)
            ->orderBy('sort_order')
            ->take(6)
            ->get();
        return response()->json($items);
    }
}
