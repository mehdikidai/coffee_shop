<?php

namespace App\Http\Controllers\web;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function __invoke(Request $request)
    {
        $rawDate = $request->input('date');
        $ordersQuery = Order::query();

        if ($rawDate && str_contains($rawDate, '|')) {
            [$from, $to] = array_map('trim', explode('|', $rawDate));

            try {
                $fromDate = Carbon::createFromFormat('d-m-y', $from)->startOfDay();
                $toDate = Carbon::createFromFormat('d-m-y', $to)->endOfDay();

                $ordersQuery->whereBetween('created_at', [$fromDate, $toDate]);

            } catch (\Exception $e) {
                return back()->withErrors(['date' => 'صيغة التاريخ غير صالحة.']);
            }
        }

        $ordersFiltered = $ordersQuery->count();
        $ordersTotal = Order::count();
        $ordersToday = Order::whereDate('created_at', today())->count();
        $ordersTotalPriceToday = Order::whereDate('created_at', today())->sum('total_price');
        $ordersTotalPriceAll = Order::sum('total_price');
        $users = User::count();
        $products = Product::count();
        $ordersTotalPriceFiltered =  $ordersQuery->sum('total_price');

        return view('home', [
            'statistics' => [
                'orders_filtered' => $ordersFiltered,
                'orders_total' => $ordersTotal,
                'orders_today' => $ordersToday,
                'users' => $users,
                'products' => $products,
                'orders_total_price_today' => $ordersTotalPriceToday,
                'orders_total_price_all' => $ordersTotalPriceAll,
                'orders_total_price_filtered' => $ordersTotalPriceFiltered,
            ],
            'date' => $rawDate
        ]);
    }
}
