<?php

namespace App\Http\Controllers\web;

use App\Models\User;
use App\Models\Order;
use App\Enum\UserRole;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $users = User::whereNot('role', UserRole::USER->value)->get();
        //$orders = Order::with(['items', 'user'])->latest()->paginate(10);

        $pagination_limit = (int) config('setting.pagination_limit');

        $orders = Order::with(['items', 'user'])
            ->when($request->user_id, fn($query) => $query->where('user_id', $request->user_id))
            ->when($request->date, fn($query) => $query->whereDate('created_at', $request->date))
            ->latest()
            ->paginate($pagination_limit);


        return view('orders', compact('orders', 'users'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order  = Order::whereId($id)->with(['items.product', 'user'])->first(); // items use a product

        return view('orderShow', compact('order'));
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

        $order = Order::with('items')->findOrFail($id);

        foreach ($order->items as $item) {

            $product = Product::with('ingredients')->findOrFail($item['product_id']);

            foreach ($product->ingredients as $ingredient) {
                $pivotQuantity = $ingredient->pivot->quantity;
                $totalQuantityUsed = $pivotQuantity * $item['quantity'];
                $ingredient->increment('stock', $totalQuantityUsed);
            }

        }

        $order->delete();

        return redirect()->back()->with('success', 'Order deleted successfully.');
    }
}
