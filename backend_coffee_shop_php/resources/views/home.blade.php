<x-layout title="Home Page" name_page="statistics">


    <div class="filter mb-3 float-end">
        <form method="GET" class="" data-bs-theme="dark">

            <div class="input-group input-group-sm">
                <input class="form-control" type="text" name="date_from" id="date_from"
                    value="{{ request('date_from') }}"
                    placeholder="{{ __('t.date_from') ?? 'date from' }}">
            </div>

            <div class="input-group input-group-sm">
                <input class="form-control" type="text" name="date_to" id="date_to"
                    value="{{ request('date_to') }}"
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
            <h3>{{ $statistics['orders_filtered'] }}</h3>
            <span><x-icon name="receipt" /> {{ __('t.orders_filtered') ?? "orders filtered" }} </span>
        </div>
        <div class="box">
            <h3>{{$statistics['users']}}</h3>
            <span><x-icon name="group" /> {{ __('t.users') ?? 'users' }} </span>
        </div>
        <div class="box">
            <h3> {{ $statistics['products'] }} </h3>
            <span><x-icon name="package_2" /> {{ __('t.products') ?? "products" }} </span>
        </div>
        <div class="box">
            <h3>{{ $statistics['orders_total'] }}</h3>
            <span><x-icon name="receipt" /> {{ __('t.orders_total') ?? "orders total" }} </span>
        </div>
        <div class="box">
            <h3>{{ $statistics['orders_today'] }}</h3>
            <span><x-icon name="receipt" /> {{ __('t.orders_today') ?? "orders today" }} </span>
        </div>
        <div class="box">
            <h3>{{ number_format($statistics['orders_total_price_filtered'], 2, ',', '.') . " "  }}
                <small>{{config('setting.currency')}}</small>
            </h3>
            <span><x-icon name="paid" /> {{ __('t.orders_total_price_filtered') ?? "orders total price filtered" }}
            </span>
        </div>
        <div class="box">
            <h3>{{ number_format($statistics['orders_total_price_today'], 2, ',', '.') . " " }}
                <small>{{config('setting.currency')}}</small>
            </h3>
            <span><x-icon name="paid" /> {{ __('t.orders_total_price_today') ?? "orders total price today" }} </span>
        </div>
        <div class="box">
            <h3>{{ number_format($statistics['orders_total_price_all'], 2, ',', '.') . " "  }}
                <small>{{config('setting.currency')}}</small>
            </h3>
            <span><x-icon name="paid" /> {{ __('t.orders_total_price') ?? "orders total price" }} </span>
        </div>
    </div>
    <div class="chart-box">
        <div class="box box-one">
            <h5 class="text-white mb-4 text-capitalize opacity-75"> {{ __('t.best_selling_product') ?? "best selling product" }} </h5>
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
                        backgroundColor: "rgba(238, 155, 0, 1)",
                        borderColor: "rgba(255, 99, 132, 0)",
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
                        borderColor: "rgba(10, 147, 150, 1)",
                        backgroundColor: "rgba(10, 147, 150, 0.1)",
                        tension: 0.3,
                        fill: true,
                        pointBackgroundColor: "rgba(10, 147, 150, 1)",
                        pointBorderColor: "rgba(10, 147, 150, 1)",
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
                        borderColor: "rgba(238, 155, 0, 1)",
                        backgroundColor: "rgba(238, 155, 0,1)",
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


    console.log(@json(array_column(array_values($best_sellers), 'user')))
    console.log(@json(array_column(array_values($best_sellers), 'total')))


</script>
