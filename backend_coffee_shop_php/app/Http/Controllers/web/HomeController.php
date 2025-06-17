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
                return back()->withErrors(['date' => 'Invalid date format.']);
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

        $ordersLast7Days = $this->ordersLast7Days();
        $dailySalesLast7Days  = $this->dailySalesLast7Days();

        //  bestSeller
        $bestSellers = $ordersQuery->with(['user', 'items.product'])->get();

        $bestSellers = $this->bestSellers($bestSellers);


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
            'orders_last_7days' => $ordersLast7Days,
            'daily_sales_last_7Days' => $dailySalesLast7Days,
            'best_sellers' => $bestSellers,
            'date' => $rawDate
        ]);
    }

    private function ordersLast7Days(): array
    {
        $fromDate = Carbon::now()->subDays(6)->startOfDay();
        $toDate = Carbon::now()->endOfDay();

        $orders = Order::with('items.product')
            ->whereBetween('created_at', [$fromDate, $toDate])
            ->get();

        $sales = [];

        foreach ($orders as $order) {
            foreach ($order->items as $item) {
                $product = $item->product;
                if (!$product) continue;

                if (!isset($sales[$product->id])) {
                    $sales[$product->id] = [
                        'product_name' => $product->name,
                        'quantity' => 0,
                    ];
                }

                $sales[$product->id]['quantity'] += $item->quantity;
            }
        }

        uasort($sales, fn($a, $b) => $b['quantity'] <=> $a['quantity']);
        $top5 = array_slice(array_values($sales), 0, 10);
        return $top5;
    }

    private function dailySalesLast7Days(): array
    {
        $fromDate = Carbon::now()->subDays(6)->startOfDay();
        $toDate = Carbon::now()->endOfDay();

        $orders = Order::whereBetween('created_at', [$fromDate, $toDate])
            ->with('items.product')
            ->get();

        $sales = [];

        for ($i = 0; $i < 7; $i++) {
            $date = Carbon::now()->subDays(6 - $i);
            $dayName = $date->format('l');
            $sales[$dayName] = 0;
        }

        foreach ($orders as $order) {
            $dayName = $order->created_at->format('l');
            /** @var \Illuminate\Support\Collection $items */
            $items = $order->items;
            $total = $items->sum(fn($item) => $item->quantity * $item->product->price);
            $sales[$dayName] += $total;
        }

        return $sales;
    }

    private function bestSellers($orders)
    {
        $sales = [];

        foreach ($orders as $order) {
            $user = $order->user;
            if (!$user) continue;

            $total = $order->items->sum(function ($item) {
                return $item->quantity * $item->product->price;
            });

            if (!isset($sales[$user->id])) {
                $sales[$user->id] = [
                    'user' => $user->name,
                    'total' => 0,
                ];
            }

            $sales[$user->id]['total'] += $total;
        }

        uasort($sales, fn($a, $b) => $b['total'] <=> $a['total']);

        return $sales;
    }
}
