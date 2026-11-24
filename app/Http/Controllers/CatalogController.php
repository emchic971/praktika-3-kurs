<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Size;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['variants.size']);
        $categories = Category::all();
        $sizes = Size::all();

        // Фильтры доступны ТОЛЬКО авторизованным
        if (auth()->check()) {
            if ($search = $request->input('search')) {
                $query->where('name', 'like', "%{$search}%");
            }
            if ($categoryId = $request->input('category_id')) {
                $query->where('category_id', $categoryId);
            }
            if ($sizeId = $request->input('size_id')) {
                $query->whereHas('variants', fn($q) => $q->where('size_id', $sizeId));
            }
            
            $sortBy = $request->input('sort_by', 'created_at');
            $sortDir = $request->input('sort_dir') === 'desc' ? 'desc' : 'asc';
            $query->orderBy($sortBy, $sortDir);
        }

        $products = $query->paginate(12)->withQueryString();

        return view('catalog.index', compact('products', 'categories', 'sizes'));
    }
}