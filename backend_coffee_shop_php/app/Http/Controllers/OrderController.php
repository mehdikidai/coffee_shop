<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class OrderController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $user = $request->user();

        $order = DB::transaction(function () use ($validated, $user) {
            $order = Order::create([
                'user_id' => $user->id,
                'table_number' => $user->table_number,
            ]);

            foreach ($validated['items'] as $item) {
                $product = Product::find($item['product_id']);
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                ]);
            }

            return $order;
        });

        return response()->json([
            'message' => 'Order created successfully.',
            'order_id' => $order->id,
        ], 201);
    }



    public function salesToday()
    {
        $today = Carbon::today();

        $sales = Order::whereDate('created_at', $today)
            ->with('items.product')
            ->get(); // get name product

        $total = 0;

        foreach ($sales as $order) {
            foreach ($order->items as $item) {
                $total += $item->price * $item->quantity;
            }
        }

        return response()->json([
            'total_sales' => $total,
            'orders_count' => $sales->count(),
            'orders' => $sales,
        ]);
    }
}
