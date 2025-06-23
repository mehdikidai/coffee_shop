<x-layout title="Home Page" name_page="statistics">


    <div class="filter mb-3 float-end">
        <form method="GET" class="" data-bs-theme="dark">

            <div class="input-group input-group-sm">
                <input class="form-control" type="text" name="date_from" id="date_from"
                    value="{{ request('date_from') }}" placeholder="{{ __('t.date_from') ?? 'date from' }}">
            </div>

            <div class="input-group input-group-sm">
                <input class="form-control" type="text" name="date_to" id="date_to" value="{{ request('date_to') }}"
                    placeholder="{{ __('t.date_to') ?? 'date to' }}">
            </div>

            <div class="input-group input-group-sm d-grid">
                <button type="submit"
                    class="btn btn-primary d-flex align-items-center gap-2 btn-filter text-capitalize"> <x-icon
                        name="event" /> {{ __('t.filter') ?? 'filter' }}</button>
            </div>

        </form>
    </div>


    <div class="statistics-boxes">

        <div class="box">
            <div class="box-tit">
                <h3 class="d-flex justify-content-between align-items-center">
                    {{ $statistics['orders_today'] }}
                </h3>
                <span class="rate {{ $statistics['percentage_change_orders'] >= 0 ? 'text-success' : 'text-danger' }}">

                    @if ($statistics['percentage_change_orders'] !== 0)
                        <x-icon name="north" />
                    @endif

                    {{ $statistics['percentage_change_orders'] }} %
                </span>
            </div>

            <span><x-icon name="receipt" /> {{ __('t.orders_today') ?? "orders today" }} </span>
        </div>


        <div class="box">

            <div class="box-tit">
                <a class="text-decoration-none" href="{{ route('orders.index', ['date' => now()->toDateString()]) }}">
                    <h3>
                        {{ number_format($statistics['orders_total_price_today'], 2, ',', '.') . " " }}
                        <small>{{config('setting.currency')}}</small>
                    </h3>
                </a>

                <span class="rate {{ $statistics['daily_income_difference'] >= 0 ? 'text-success' : 'text-danger' }}">

                    @if ($statistics['daily_income_difference'] !== 0)
                        <x-icon name="north" />
                    @endif

                    {{ $statistics['daily_income_difference'] }} %

                </span>
            </div>
            <span><x-icon name="paid" /> {{ __('t.orders_total_price_today') ?? "orders total price today" }} </span>

        </div>


        <div class="box">
            <div class="box-tit justify-content-start">
                <h3>{{ $statistics['orders_filtered'] }}</h3>
            </div>

            <span><x-icon name="receipt" /> {{ __('t.orders_filtered') ?? "orders filtered" }} </span>
        </div>

        <div class="box">
            <div class="box-tit">
                <h3>{{$statistics['users']}}</h3>
            </div>
            <span><x-icon name="group" /> {{ __('t.users') ?? 'users' }} </span>
        </div>

        <div class="box">
            <div class="box-tit">
                <h3> {{ $statistics['products'] }} </h3>
            </div>

            <span><x-icon name="package_2" /> {{ __('t.products') ?? "products" }} </span>
        </div>

        <div class="box">
            <div class="box-tit">
                <h3>
                    {{ $statistics['total_procurement_cost_today'] }}
                    <small>{{config('setting.currency')}}</small>
                </h3>
            </div>
            <span><x-icon name="receipt" /> {{ __('t.stock_purchase') ?? "stock purchase" }} </span>
        </div>



        <div class="box">

            <div class="box-tit">
                <h3>{{ number_format($statistics['orders_total_price_filtered'], 2, ',', '.') . " "  }}
                    <small>{{config('setting.currency')}}</small>
                </h3>
            </div>


            <span><x-icon name="paid" /> {{ __('t.orders_total_price_filtered') ?? "orders total price filtered" }}
            </span>
        </div>



        <div class="box">
            <div class="box-tit">
                <h3>{{ number_format($statistics['orders_total_price_all'], 2, ',', '.') . " "  }}
                    <small>{{config('setting.currency')}}</small>
                </h3>
            </div>

            <span><x-icon name="paid" /> {{ __('t.orders_total_price') ?? "orders total price" }} </span>
        </div>

    </div>
    <div class="chart-box">
        <div class="box box-one">
            <h5 class="text-white mb-4 text-capitalize opacity-75">
                {{ __('t.best_selling_product') ?? "best selling product" }}
            </h5>
            @if (!empty($best_selling_products) && count($best_selling_products) > 0)
                <canvas id="best-selling-product"></canvas>
            @else
                <span class="text-white opacity-50 text-capitalize">message</span>
            @endif
        </div>
        <div class="box box-two">
            <h5 class="text-white mb-4 text-capitalize opacity-75"> {{ __('t.weekly_revenue') ?? "weekly revenue" }}
            </h5>
            <canvas id="best-seller"></canvas>

        </div>
        <div class="box box-three">
            <h5 class="text-white mb-4 text-capitalize opacity-75"> {{ __('t.best_seller') ?? "best seller" }} </h5>
            @if (!empty($best_sellers) && count($best_sellers) > 0)
                <canvas id="best-user"></canvas>
            @else
                <span class="text-white opacity-50 text-capitalize">message</span>
            @endif
        </div>
    </div>

</x-layout>


<script>

    // chart js const

    const darkChartOptions = {
        responsive: true,
        plugins: {
            legend: {
                display: false,
            },
        },
        scales: {
            x: {
                ticks: {
                    color: "#fff",
                    display: true,
                    autoSkip: false,
                    precision: 0,
                    font: {
                        size: 12
                    }
                },
                grid: {
                    color: "rgba(255,255,255,0.05)",
                },
            },
            y: {
                beginAtZero: true,
                ticks: {
                    color: "#fff",

                },
                grid: {
                    color: "rgba(255,255,255,0.05)",
                },
            },
        },
    };

    const ctxBestSeller = document.getElementById("best-seller");
    const ctxBestSellingProduct = document.getElementById("best-selling-product");
    const bestUser = document.getElementById("best-user");


    if (ctxBestSellingProduct !== null) {
        new Chart(ctxBestSellingProduct, {
            type: "bar",
            data: {
                labels: @json(array_column($best_selling_products, 'product_name')),
                datasets: [
                    {
                        label: "# of Votes",
                        data: @json(array_column($best_selling_products, 'quantity')),
                        borderWidth: 0,
                        backgroundColor: "#ecba53",
                        borderColor: "#ecba53",
                        barThickness: 10,
                    },
                ],
            },
            options: {
                ...darkChartOptions,
                indexAxis: 'y',
            },
        });
    }

    if (ctxBestSeller !== null) {
        new Chart(ctxBestSeller, {
            type: "line",
            data: {
                labels: @json(array_map(fn($el) => __("t." . strtolower($el)), array_keys($daily_sales_last_7Days))),
                datasets: [
                    {
                        label: "Weekly Sales",
                        data: @json(array_values($daily_sales_last_7Days)),
                        borderColor: "#94d2bd",
                        backgroundColor: "rgba(10, 147, 150, 0.1)",
                        tension: 0.3,
                        fill: true,
                        pointBackgroundColor: "#142629",
                        pointBorderColor: "#94d2bd",
                    }
                ],
            },
            options: darkChartOptions,
        });
    }

    if (bestUser !== null) {
        new Chart(bestUser, {
            type: "bar",
            data: {
                labels: @json(array_column(array_values($best_sellers), 'user')),
                datasets: [
                    {
                        label: "Weekly Sales",
                        data: @json(array_column(array_values($best_sellers), 'total')),
                        borderColor: "#ecba53",
                        backgroundColor: "#ecba53",
                        barThickness: 10,
                    }
                ],
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false,
                    },
                },
                scales: {
                    x: {
                        ticks: {
                            color: "#fff",
                            display: true,
                            autoSkip: false,
                            precision: 0,
                            stepSize: 1,
                            font: {
                                size: 12
                            }
                        },
                        grid: {
                            color: "rgba(255,255,255,0.05)",
                        },
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: "#fff",

                        },
                        grid: {
                            color: "rgba(255,255,255,0.05)",
                        },
                    },
                },
            },
        });
    }

</script>
