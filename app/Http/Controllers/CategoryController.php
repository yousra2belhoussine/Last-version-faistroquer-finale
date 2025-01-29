<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('ads')
            ->orderBy('name')
            ->get();

        return view('categories.index', [
            'categories' => $categories,
        ]);
    }

    public function show(Category $category)
    {
        $ads = $category->ads()
            ->with(['user', 'category'])
            ->where('status', 'active')
            ->latest()
            ->paginate(12);

        return view('categories.show', [
            'category' => $category,
            'ads' => $ads,
        ]);
    }
} 