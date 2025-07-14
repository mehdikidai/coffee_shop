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

        $pagination_limit = pagination_limit();

        $stock_log = StockLog::with(['ingredient', 'user'])->latest()->paginate($pagination_limit);

        $ingredients = Ingredient::all();

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
            'receipt_amount' => 'required|numeric|min:0',
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

        $number = 'INV-' . Str::uuid();

        DB::transaction(function () use ($request, $receiptPath, $number, $validated) {


            $receipt = Receipt::create([
                'receipt_photo' => $receiptPath,
                'receipt_amount' => $validated['receipt_amount'],
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
        
        $stockLog = StockLog::with(['ingredient', 'receipt'])->findOrFail($id);

        DB::transaction(function () use ($stockLog) {

            $ingredient = $stockLog->ingredient;
            $ingredient->stock = max(0, $ingredient->stock - $stockLog->quantity);
            $ingredient->save();

            $stockLog->delete();

            $receipt = $stockLog->receipt;
            if ($receipt && $receipt->stockLogs()->count() === 0) {
                if ($receipt->receipt_photo && file_exists(public_path($receipt->receipt_photo))) {
                    @unlink(public_path($receipt->receipt_photo));
                }
                $receipt->delete();
            }
        });

        return redirect()->back()->with('success', __('t.stock_log_deleted_successfully') ?? 'Stock log deleted successfully');

    }




}
