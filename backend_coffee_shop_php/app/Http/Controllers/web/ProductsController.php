<?php

namespace App\Http\Controllers\web;

use App\Models\Product;
use App\Models\Category;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {


        $search = $request->input('search');

        $pagination_limit = pagination_limit();

        $products = Product::with(['category', 'ingredients'])
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%$search%")
                    ->orWhere('price', 'like', "%$search%")
                    ->orWhereHas('category', fn($q) => $q->where('name', 'like', "%$search%"))
                    ->orWhereHas('ingredients', fn($q) => $q->where('name', 'like', "%$search%"));
            })
            ->orderBy('id')
            ->paginate($pagination_limit);

        $categories = Cache::rememberForever('all_categories', fn() => Category::all());

        return view('products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'min:3'],
            'price' => ['required', 'numeric', 'min:0'],
            'photo' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
        ], [
            'name.required' => 'The name field is required.',
            'name.min' => 'The name must be at least 3 characters.',
            'price.required' => 'The price field is required.',
            'price.numeric' => 'The price must be a number.',
            'price.min' => 'The price must be zero or higher.',
            'photo.required' => 'The photo field is required.',
            'photo.image' => 'The uploaded file must be an image.',
            'photo.mimes' => 'The photo must be a file of type: jpeg, png, jpg, gif, svg.',
            'photo.max' => 'The photo must not be larger than 2MB.',
            'category_id.required' => 'The category field is required.',
            'category_id.exists' => 'The selected category does not exist.',
        ]);

        if ($request->hasFile('photo')) {

            $host = request()->getHost();
            $subdomain = explode('.', $host)[0];

            $path = public_path("uploads/products/$subdomain");

            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }

            $fileName = time() . '.' . $request->photo->extension();
            $request->photo->move($path, $fileName);

            $uri = "uploads/products/$subdomain/$fileName";
            $data['photo'] = asset($uri);
        }


        Product::create($data);

        return to_route('products.index')->with('success', 'Product added successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {

        $product = Product::with('category')->findOrFail($id);

        $categories = Cache::rememberForever('all_categories', fn() => Category::all());

        $ingredients = Ingredient::all();

        $oldIngredients = $product->ingredients->map(
            fn($ingredient)
            => [
                'id' => $ingredient->id,
                'quantity' => $ingredient->pivot->quantity,
            ]
        )->toArray();

        return view("products.edit", compact('product', 'categories', 'ingredients', 'oldIngredients'));
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, string $id)
    // {
    //     $product = Product::findOrFail($id);

    //     $data = $request->validate([
    //         'name' => ['required', 'string', 'min:3'],
    //         'price' => ['required', 'numeric', 'min:0'],
    //         'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
    //         'category_id' => ['required', 'integer', 'exists:categories,id'],
    //         'ingredients.*.id' => 'required|exists:ingredients,id',
    //         'ingredients.*.ingredient' => 'required|integer|min:1',
    //     ]);


    //     if ($request->hasFile('photo')) {

    //         $oldPath = public_path(parse_url($product->photo, PHP_URL_PATH));
    //         if (file_exists($oldPath)) {
    //             unlink($oldPath);
    //         }

    //         $fileName = time() . '.' . $request->photo->extension();
    //         $request->photo->move(public_path('uploads/products'), $fileName);
    //         $uri = "uploads/products/$fileName";
    //         $data['photo'] = asset($uri);
    //     }


    //     $product->update($data);

    //     return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    // }


    public function update(Request $request, string $id): RedirectResponse
    {
        $product = Product::findOrFail($id);
        $ingredients = $request->input('ingredients', []);

        $filteredIngredients = array_filter(
            $ingredients,
            fn($ing)
            => isset($ing['id']) && $ing['id'] !== '' && isset($ing['quantity']) && $ing['quantity'] !== ''
        );

        $request->merge(['ingredients' => $filteredIngredients]);

        $data = $request->validate([
            'name' => ['required', 'string', 'min:3'],
            'price' => ['required', 'numeric', 'min:0'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'ingredients' => ['sometimes', 'array'],
            'ingredients.*.id' => ['required', 'integer', 'exists:ingredients,id'],
            'ingredients.*.quantity' => ['required', 'numeric', 'min:0.01'],
        ]);

        if ($request->hasFile('photo')) {
            $oldPath = public_path(parse_url($product->photo, PHP_URL_PATH));
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
            $fileName = time() . '.' . $request->photo->extension();
            $request->photo->move(public_path('uploads/products'), $fileName);
            $uri = "uploads/products/$fileName";
            $data['photo'] = asset($uri);
        }


        $product->update($data);

        if (isset($data['ingredients'])) {
            $ingredients = [];
            foreach ($data['ingredients'] as $ingredient) {
                $ingredients[$ingredient['id']] = ['quantity' => $ingredient['quantity']];
            }
            $product->ingredients()->sync($ingredients);
        }

        return redirect()->back()->with('success', 'Product updated successfully.');
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->back()->with('success', 'Product deleted successfully.');
    }

    public function toggleVisibility(string $id): RedirectResponse
    {
        $product = Product::findOrFail($id);
        $product->visible = !$product->visible;
        $product->save();
        $status = $product->visible ? 'visible' : 'hidden';
        return redirect()->back()->with('success', "Product is now $status.");
    }
}
