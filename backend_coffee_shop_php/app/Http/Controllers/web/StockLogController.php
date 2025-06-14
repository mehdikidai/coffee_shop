<?php

namespace App\Http\Controllers\web;

use App\Models\Receipt;
use App\Models\StockLog;
use Illuminate\View\View;
use App\Models\Ingredient;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class StockLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {

        $stock_log = StockLog::with(['ingredient', 'user'])->latest()->paginate(10);

        $ingredients = Ingredient::latest()->paginate(10);

        return view('stockLog', compact('stock_log', 'ingredients'));
    }

    /**
     * Display page add to stock.
     */

    public function showAddToStock(): View
    {

        $ingredients = Ingredient::all();

        return view('add-to-stock', compact('ingredients'));
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
        $validated = $request->validate([
            'receipt_photo' => 'nullable|image|max:2048',
            'ingredients' => 'required|array|min:1',
            'ingredients.*.ingredient_id' => 'required|exists:ingredients,id',
            'ingredients.*.quantity' => 'required|numeric|min:1',
        ]);

        $receiptPath = null;

        if ($request->hasFile('receipt_photo')) {
            $fileName = time() . '.' . $request->receipt_photo->extension();
            $request->receipt_photo->move(public_path('uploads/receipts'), $fileName);
            $receiptPath = "uploads/receipts/$fileName";
        }

        do {
            $number = "INV-" . mt_rand(1000000000000000, 9999999999999999);
        } while (Receipt::where('number', $number)->exists());

        DB::transaction(function () use ($request, $receiptPath,$number) {


            $receipt = Receipt::create([
                'receipt_photo' => $receiptPath,
                'number' => $number,
            ]);

            foreach ($request->ingredients as $ingredient) {

                $ing = Ingredient::findOrFail($ingredient['ingredient_id']);
                $ing->stock += $ingredient['quantity'];
                $ing->save();

                StockLog::create([
                    'ingredient_id' => $ingredient['ingredient_id'],
                    'quantity' => $ingredient['quantity'],
                    'receipt_id' => $receipt->id,
                    'user_id' => Auth::id(),
                ]);
            }
        });

        return redirect()->route('stock.log.index')->with('success', __('t.stock_updated_successfully') ?? "Stock updated successfully");
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
