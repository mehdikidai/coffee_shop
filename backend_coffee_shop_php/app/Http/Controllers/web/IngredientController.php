<?php

namespace App\Http\Controllers\web;

use App\Models\Ingredient;
use Illuminate\Http\Request;
use App\Rules\MustBeLessThan;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class IngredientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {

        $ingredients = Ingredient::latest()->paginate(10);

        return view('ingredients', compact('ingredients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'unique:ingredients,name'],
            'unit' => ['required', 'string'],
            'unit_name' => ['required', 'string'],
            'stock' => ['required', 'numeric', 'min:0'],
            'price_per_unit' => ['required', 'numeric', 'min:0'],
            'stock_threshold' => ['required', 'numeric', 'min:0',  new MustBeLessThan('stock')],
        ]);

        Ingredient::create($data);

        return redirect()
            ->back()
            ->with('success', 'Ingredient created successfully.');;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ingredient $ingredient): View
    {
        return view('ingredientsEdit', compact('ingredient'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $ingredient = Ingredient::findOrFail($id);

        $data = $request->validate([
            'name' => ['required', 'string', "unique:ingredients,name,{$ingredient->id}"],
            'unit' => ['required', 'string'],
            'unit_name' => ['required', 'string'],
            'stock' => ['required', 'numeric', 'min:0'],
            'price_per_unit' => ['required', 'numeric', 'min:0'],
            'stock_threshold' => ['required', 'numeric', 'min:0', new MustBeLessThan('stock')],
        ]);

        $ingredient->update($data);

        return redirect()->route('ingredients.index')->with('success', 'Ingredient updated successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateStock(Request $request, string $id): RedirectResponse
    {
        $ingredient = Ingredient::findOrFail($id);

        $data = $request->validate([
            'stock' => ['required', 'numeric', 'min:0'],
        ]);

        $ingredient->update($data);

        return redirect()->route('ingredients.index')->with('success', 'Stock updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ingredient $ingredient): RedirectResponse
    {
        $ingredient->delete();

        return redirect()->back()->with('success', 'Ingredient deleted successfully.');
    }
}
