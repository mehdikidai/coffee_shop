<x-layout title="Home Page" name_page="statistics">


    <div class="filter mb-3 float-end">
        <form method="GET" class="" data-bs-theme="dark">
            <div class="input-group input-group-sm">
                <input class="form-control" type="text" name="date" id="input_filter_statistics"
                    value="{{ request('date') }}" placeholder="{{ __('t.date_from') ?? 'date from' }} | {{ __('t.date_to') ?? 'date to' }}">
            </div>
            <div class="input-group input-group-sm d-grid">
                <button type="submit" class="btn btn-primary d-flex align-items-center gap-2 btn-filter text-capitalize"> <x-icon
                        name="event" /> {{ __('t.filter') ?? 'filter' }}</button>
            </div>

        </form>
    </div>

    <div class="statistics-boxes">
        <div class="box">
            <h3>{{ $statistics['orders_filtered'] }}</h3>
            <span><x-icon name="receipt" />orders filtered</span>
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
            <span><x-icon name="receipt" />orders total</span>
        </div>
        <div class="box">
            <h3>{{ $statistics['orders_today'] }}</h3>
            <span><x-icon name="receipt" />orders today</span>
        </div>
        <div class="box">
            <h3>{{ number_format($statistics['orders_total_price_filtered'], 2, ',', '.') . " "  }}
                <small>{{config('setting.currency')}}</small> </h3>
            <span><x-icon name="paid" />orders total price filtered</span>
        </div>
        <div class="box">
            <h3>{{ number_format($statistics['orders_total_price_today'], 2, ',', '.') . " " }}
                <small>{{config('setting.currency')}}</small>
            </h3>
            <span><x-icon name="paid" />orders total price today</span>
        </div>
        <div class="box">
            <h3>{{ number_format($statistics['orders_total_price_all'], 2, ',', '.') . " "  }}
                <small>{{config('setting.currency')}}</small>
            </h3>
            <span><x-icon name="paid" />orders total price</span>
        </div>
    </div>




</x-layout>
