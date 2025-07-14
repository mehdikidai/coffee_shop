<?php

namespace App\Http\Controllers\web;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Receipt;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class HomeController extends Controller
{
    public function __invoke(Request $request): RedirectResponse|View
    {


        $ordersQuery = Order::query();
        $receiptQuery = Receipt::query();

        // date from => date to
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');


        try {
            if ($dateFrom && $dateTo) {
                $fromDate = Carbon::createFromFormat('d-m-Y', $dateFrom)->startOfDay(); // 12-06-2025
                $toDate = Carbon::createFromFormat('d-m-Y', $dateTo)->endOfDay();

                if ($fromDate->gt($toDate)) {
                    return back()->withErrors(['date' => "the start date must be earlier than or equal to the end date"]);
                }

                $ordersQuery->whereBetween('created_at', [$fromDate, $toDate]);
                $receiptQuery->whereBetween('created_at', [$fromDate, $toDate]);

            } elseif ($dateFrom && !$dateTo) {

                $onlyDate = Carbon::createFromFormat('d-m-Y', $dateFrom)->toDateString();

                $ordersQuery->whereDate('created_at', $onlyDate);
                $receiptQuery->whereDate('created_at', $onlyDate);

            }
        } catch (\Exception $e) {
            return back()->withErrors(['date' => "invalid date format"]);
        }



        $ordersFiltered = $ordersQuery->count();

        $totalProcurementCostToday = $receiptQuery->sum('receipt_amount');


        // ---------------

        $ordersToday = Order::whereDate('created_at', today())->count();
        $ordersYesterday = Order::whereDate('created_at', Carbon::yesterday())->count();
        $percentageChangeOrders = $this->percentageChange($ordersToday, $ordersYesterday);

        // ---------------

        $ordersTotalPriceToday = Order::whereDate('created_at', today())->sum('total_price');
        $dailyExpectedIncome = (int) setting('daily_expected_income', 200);
        $dailyIncomeDifference = $this->percentageChange($ordersTotalPriceToday, $dailyExpectedIncome);

        // ---------------

        $ordersTotalPriceAll = Order::sum('total_price');
        $users = User::count();
        $products = Product::count();
        $ordersTotalPriceFiltered =  $ordersQuery->sum('total_price');

        // best_selling_products_query
        $best_selling_products_query = $ordersQuery->with('items.product')->get();
        $best_selling_products = $this->best_selling_products($best_selling_products_query);


        // daily sales last 7 days
        $dailySalesLast7Days  = $this->dailySalesLast7Days();

        //  best sellers query
        $bestSellers_query = $ordersQuery->with(['user', 'items.product'])->get();
        $bestSellers = $this->bestSellers($bestSellers_query);



        // return
        return view('home', [
            'statistics' => [
                'orders_filtered' => $ordersFiltered,
                'orders_today' => $ordersToday,
                'total_procurement_cost_today' =>  $totalProcurementCostToday,
                'users' => $users,
                'products' => $products,
                'orders_total_price_today' => $ordersTotalPriceToday,
                'orders_yesterday' => $ordersYesterday,
                'percentage_change_orders' => $percentageChangeOrders,
                'orders_total_price_all' => $ordersTotalPriceAll,
                'orders_total_price_filtered' => $ordersTotalPriceFiltered,
                'daily_income_difference' => $dailyIncomeDifference
            ],
            'best_selling_products' => $best_selling_products,
            'daily_sales_last_7Days' => $dailySalesLast7Days,
            'best_sellers' => $bestSellers,
            'date_from' => $dateFrom,
            'date_to' => $dateTo,
            'daily_expected_income' => $dailyExpectedIncome
        ]);
    }

    private function best_selling_products($orders): array
    {
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

        return  array_slice($sales, 0, 5, true);
    }

    private function percentageChange($ordersToday, $ordersYesterday): int
    {

        $percentageChange = null;

        if ($ordersYesterday > 0) {
            $percentageChange = (($ordersToday - $ordersYesterday) / $ordersYesterday) * 100;
        } elseif ($ordersToday > 0) {
            $percentageChange = 100;
        } else {
            $percentageChange = 0;
        }

        return (int) $percentageChange;
    }
}
