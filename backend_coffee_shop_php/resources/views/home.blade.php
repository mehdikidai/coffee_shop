<x-layout title="Home Page" name_page="statistics">


    <div class="filter mb-3 float-end">
        <form method="GET" class="" data-bs-theme="dark">
            <div class="input-group input-group-sm">
                <input class="form-control" type="text" name="date" id="input_filter_statistics" value="{{ request('date') }}"
                    placeholder="dd-mm-yy | dd-mm-yy">
            </div>
            <div class="input-group input-group-sm d-grid">
                <button type="submit" class="btn btn-primary d-flex align-items-center gap-2 btn-filter"> <x-icon name="event" /> Filter</button>
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
            <span><x-icon name="group" />users</span>
        </div>
        <div class="box">
            <h3> {{ $statistics['products'] }} </h3>
            <span><x-icon name="package_2" />products</span>
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
            <h3>{{ $statistics['orders_total_price_filtered'] }}</h3>
            <span><x-icon name="paid" />orders total price filtered</span>
        </div>
        <div class="box">
            <h3>{{ $statistics['orders_total_price_today'] }}</h3>
            <span><x-icon name="paid" />orders total price today</span>
        </div>
        <div class="box">
            <h3>{{ $statistics['orders_total_price_all'] }}</h3>
            <span><x-icon name="paid" />orders total price</span>
        </div>
    </div>




</x-layout>
