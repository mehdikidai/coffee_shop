<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class SheetController extends Controller
{
    public function index(Request $request)
    {

        $search = trim((string) $request->input('search'));

        $pagination_limit = pagination_limit();

        $orders = OrderItem::with(['product', 'order.user'])
            ->when($search, function ($query) use ($search) {
                $query->whereHas('product', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                })
                    ->orWhereHas('order', function ($q) use ($search) {
                        $q->where('id', 'like', '%' . $search . '%');
                    });
            })
            ->latest()
            ->paginate($pagination_limit);



        //$orders = OrderItem::with(['product', 'order.user'])->latest()->paginate($pagination_limit);

        //dd($orders->toArray());

        return view('sheet', compact('orders'));
    }
}
