<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Barryvdh\DomPDF\Facade\Pdf;

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

        Gate::authorize('order-create');

        $order = DB::transaction(function () use ($validated, $user) {

            $total = 0;

            $order = Order::create([
                'user_id' => $user->id,
                'table_number' => $user->table_number,
                'total_price' => 0,
            ]);

            foreach ($validated['items'] as $item) {

                $product = Product::with('ingredients')->findOrFail($item['product_id']);

                foreach ($product->ingredients as $ingredient) {

                    $pivotQuantity = $ingredient->pivot->quantity;

                    $totalQuantityUsed = $pivotQuantity * $item['quantity'];

                    $ingredient->stock = max(0, $ingredient->stock - $totalQuantityUsed);

                    $ingredient->save();

                }

                $lineTotal = $product->price * $item['quantity'];

                $total += $lineTotal;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                ]);
            }


            $order->update([
                'total_price' => $total,
            ]);

            return $order;
        });

        return response()->json([
            'message' => 'Order created successfully.',
            'order_id' => $order->id,
        ], 201);
    }



    public function salesToday(Request $request)
    {

        $today = Carbon::today();
        $user = $request->user();

        $sales = Order::where('user_id', $user->id)
            ->whereDate('created_at', $today)
            ->with('items.product')
            ->orderBy('created_at', 'desc')
            ->get();

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


    public function printInvoice($id)
    {
        $order = Order::with(['items.product', 'user'])->findOrFail($id);
        $name_store = setting('site_name', 'app');

        $width = 226.8;
        $baseHeight = 150;
        $rowHeight = 25;
        $footer = 100;
        $totalHeight = $baseHeight + ($rowHeight * $order->items->count()) + $footer;

        $customSize = [0, 0, $width, $totalHeight];

        $pdf = Pdf::loadView('order-invoice', compact('order', 'name_store'))
            ->setPaper($customSize, 'portrait');

        $fileName = "order-invoice-{$order->id}.pdf";

        
        if (!file_exists(public_path('invoices'))) {
            mkdir(public_path('invoices'), 0777, true);
        }

        
        $path = public_path("invoices/{$fileName}");
        $pdf->save($path);

        return response()->json([
            'success' => true,
            'url' => asset("invoices/{$fileName}")
        ]);
    }


}
