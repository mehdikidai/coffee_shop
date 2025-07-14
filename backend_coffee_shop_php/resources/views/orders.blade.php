<x-layout title="orders Page" name_page="page-orders">

    <x-only-admin>
        <div class="filter filter-order mb-3">
            <form method="GET" class="d-flex gap-2 " data-bs-theme="dark" id="form_filter_orders">
                <div class="input-group input-group-sm">

                    <select name="user_id" id="user_id" class="form-select">
                        <option value=""> {{ __('t.all') ?? "all" }} </option>
                        @foreach ($users as $user)
                            <option class="text-capitalize" value="{{ $user->id }}"
                                @selected(request('user_id') == $user->id)>{{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="input-group input-group-sm">
                    <input class="form-control text-capitalize" type="text" name="date" id="input_filter"
                        value="{{ request('date') }}" placeholder="{{ __('t.filter_by_date') ?? "filter by date" }}">
                </div>
                <div class="input-group-sm d-grid">
                    <button type="submit"
                        class="btn btn-primary d-flex align-items-center gap-2 btn-filter text-capitalize px-3"> <x-icon
                            name="event" /> {{ __('t.filter') ?? "filter" }} </button>
                </div>

            </form>
        </div>

    </x-only-admin>



    <x-only-admin>

        @if($orders->isNotEmpty())
            <div class="cont-table">
                <table class="table table-bordered table-sm" data-bs-theme="dark">
                    <thead>
                        <tr>
                            <th scope="col" class="th-order-id text-capitalize"> {{ __('t.order_id') ?? "order id" }} </th>
                            <th scope="col" class="th-order-name text-capitalize"> {{ __('t.name') ?? "name" }} </th>
                            <th scope="col" class="th-quantity text-capitalize"> {{ __('t.quantity') ?? "quantity" }} </th>
                            <th scope="col" class="th-total text-capitalize">{{ __('t.total') ?? "total" }}</th>
                            <th scope="col" class="th-date text-capitalize">{{ __('t.date') ?? "date" }} </th>
                            <th scope="col" class="th-actions text-capitalize"> {{ __('t.actions') ?? "actions" }} </th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($orders as $order)
                            <tr>
                                <th scope="row" class="px-2">{{ $order->id }}</th>
                                <td class="px-2">{{ $order->user->name }}</td>
                                <td class="px-2">{{ $order->items->count() }}</td>
                                <td class="px-2">{{ $order->total_price }} <small>{{ config('setting.currency') }}</small></td>
                                <td class="px-2">{{ $order->created_at }}</td>
                                <td class="td-actions">
                                    <div class="box-actions">

                                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-primary">
                                            <x-icon name="list_alt" /> {{ __('t.details') }}
                                        </a>
                                        <a href="{{ route('orders.invoice', $order->id) }}" target="_blank" class="btn btn-sm btn-success text-capitalize">
                                            <x-icon name="print" /> print
                                        </a>
                                        <form class="form-delete-order" action="{{ route('orders.destroy', $order->id) }}"
                                            method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger">
                                                <x-icon name="delete" /> {{ __('t.delete') }}
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

            {{ $orders->links() }}


        @else


            <div class="box-alert">
                <div class="k-alert alert alert-secondary" role="alert">
                    {{ __('alert.there_is_nothing') ?? "there is nothing" }}
                </div>
            </div>


        @endif

    </x-only-admin>

    <x-not-admin>
        <x-message>This content is for admins only.</x-message>
    </x-not-admin>

</x-layout>


<x-swal class_form=".form-delete-order"></x-swal>
