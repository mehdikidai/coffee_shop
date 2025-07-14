<?php

namespace App\Http\Controllers\web;

use App\Models\User;
use App\Models\Order;
use App\Enum\UserRole;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Receipt;
use App\Services\TenantService;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {

        $users = User::whereNot('role', UserRole::USER->value)->get();

        $pagination_limit = pagination_limit();

        $orders = Order::with(['items', 'user'])
            ->when($request->user_id, fn($query) => $query->where('user_id', $request->user_id))
            ->when($request->date, fn($query) => $query->whereDate('created_at', $request->date))
            ->latest()
            ->paginate($pagination_limit)
            ->appends($request->only(['user_id', 'date']));

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
    public function show(string $id): View
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
    public function destroy(string $id): RedirectResponse
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

    public function printInvoice($id)
    {
        $order = Order::with(['items.product', 'user'])->findOrFail($id);
        $name_store =  setting('site_name','app');

        $width = 226.8;

        $baseHeight = 150; 
        $rowHeight = 25; 
        $footer = 100;
        $totalHeight = $baseHeight + ($rowHeight * $order->items->count()) + $footer;

        $customSize = [0, 0, 226.8, $totalHeight];

        $pdf = Pdf::loadView('order-invoice', compact('order','name_store'))
            ->setPaper($customSize, 'portrait');


        return $pdf->stream("order-invoice-{$order->id}.pdf", ['Attachment' => false]); // print outomatic

    }


    public function printInvoiceTest($id)
    {
        $order = Order::with(['items.product', 'user'])->findOrFail($id);

        $name_store =  setting('site_name','app');

        $width = 226.8;

        $baseHeight = 150; 
        $rowHeight = 25; 
        $footer = 100;
        $totalHeight = $baseHeight + ($rowHeight * $order->items->count()) + $footer;

        $customSize = [0, 0, 226.8, $totalHeight];

        $pdf = Pdf::loadView('order-invoice', compact('order','name_store'))
            ->setPaper($customSize, 'portrait');


        return view("order-invoice",compact('order','name_store'));

    }



}
