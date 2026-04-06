<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    protected function requireAuth(): ?RedirectResponse
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        return null;
    }

    public function index()
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $categories = Category::withCount('products')->get();

        return view('categories.index', [
            'categories' => $categories,
        ]);
    }

    public function create()
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        return view('categories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string|max:1000',
        ]);

        Category::create($request->only(['name', 'description']));

        return redirect()->route('categories.index');
    }

    public function edit(Category $category)
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        return view('categories.edit', [
            'category' => $category,
        ]);
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string|max:1000',
        ]);

        $category->update($request->only(['name', 'description']));

        return redirect()->route('categories.index');
    }

    public function destroy(Category $category): RedirectResponse
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $category->delete();

        return redirect()->route('categories.index');
    }
}
