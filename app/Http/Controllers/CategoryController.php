<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->latest()->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'show_in_menu' => 'nullable|boolean',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('categories', 'public');
        }

        $bannerPath = null;
        if ($request->hasFile('banner_image')) {
            $bannerPath = $request->file('banner_image')->store('categories/banners', 'public');
        }

        $slug = Str::slug($validated['name']);
        $originalSlug = $slug;
        $count = 1;

        while (Category::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        Category::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'image' => $imagePath,
            'banner_image' => $bannerPath,
            'show_in_menu' => $request->has('show_in_menu') ? 1 : 0,
        ]);

        return back()->with('success', 'Kategori ve görselleri başarıyla eklendi.');
    }

    public function edit(Category $category)
    {
        $categories = Category::withCount('products')->latest()->get();
        return view('admin.categories.edit', compact('category', 'categories'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'show_in_menu' => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $category->image = $request->file('image')->store('categories', 'public');
        }

        if ($request->hasFile('banner_image')) {
            if ($category->banner_image) {
                Storage::disk('public')->delete($category->banner_image);
            }
            $category->banner_image = $request->file('banner_image')->store('categories/banners', 'public');
        }

        $slug = Str::slug($validated['name']);
        $originalSlug = $slug;
        $count = 1;

        while (Category::where('slug', $slug)->where('id', '!=', $category->id)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        $category->name = $validated['name'];
        $category->slug = $slug;
        $category->show_in_menu = $request->has('show_in_menu') ? 1 : 0;
        $category->save();

        return redirect()->route('admin.categories.index')->with('success', 'Kategori başarıyla güncellendi.');
    }

    public function destroy(Category $category)
    {
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }
        
        if ($category->banner_image) {
            Storage::disk('public')->delete($category->banner_image);
        }
        
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Kategori başarıyla silindi.');
    }
}