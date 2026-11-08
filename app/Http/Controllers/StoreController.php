<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('sku', 'like', '%' . $searchTerm . '%');
            });
        }

        if ($request->has('category') && $request->category != '') {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $products = $query->orderBy('name', 'asc') // Veya 'sku' bazlı sıralama
                  ->paginate(18)
                  ->withQueryString()
                  ->fragment('urunler');
        $productsCount = Product::count();
        
        $categories = Category::with('products')->get();
        
        $bestSellers = Product::with('category')->where('is_best_seller', true)->latest()->take(7)->get();

        $discountedProducts = Product::with('category')->whereNotNull('discount_price')->where('discount_price', '>', 0)->latest()->take(6)->get();

        return view('store.index', compact('products', 'categories', 'bestSellers', 'discountedProducts', 'productsCount'));
    }
}