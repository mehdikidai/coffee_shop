<?php

namespace App\Http\Controllers\web;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $categories = Category::with('products')->orderBy('index','desc')->paginate(10);
        return view('categories', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|unique:categories,name',
            'icon' => 'nullable|string',
            'index' => 'nullable|string',
        ]);

        Category::create($data);
        $this->clearCache();
        return redirect()->back()->with('success', 'Category created successfully.');
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('categoriesEdit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'id' => 'required|exists:categories,id',
            'name' => "required|string|unique:categories,name,{$request->id}",
            'icon' => 'required|string',
            'index' => 'required|int',
        ]);

        $category = Category::findOrFail($data['id']);
        $category->update($data);
        $this->clearCache();
        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): RedirectResponse
    {

        $category->delete();
        $this->clearCache();
        return redirect()->back()->with('success', 'Category deleted successfully.');
    }

    private function clearCache()
    {
        Cache::forget('all_categories');
    }
}
