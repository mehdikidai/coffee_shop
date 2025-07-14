<x-layout title="Sheet Page" name_page="page-sheet">


    <div class="box-title d-flex justify-content-end mb-3" data-bs-theme="dark">
        <form method="get">
            <div class="d-flex input-group-sm gap-2">
                <input class="form-control" type="text" value="{{ request('search') }}" name="search" id="search"
                    placeholder="{{ __('t.search') ?? 'search' }}">
                <button class="btn btn-sm btn-primary px-3"> {{ __('t.search') ?? 'search' }} </button>
            </div>

        </form>
    </div>


    @if ($orders->count() > 0)
        <div class="cont-table">
            <table class="table table-bordered table-sm" data-bs-theme="dark">
                <thead>
                    <tr>
                        <th scope="col" class="th-id text-capitalize">{{ __('t.order_id') ?? "order id" }}</th>
                        <th scope="col" class="th-name text-capitalize">{{ __('t.name') ?? "name" }}</th>
                        <th scope="col" class="th-quantity text-capitalize">{{ __('t.quantity') ?? "quantity" }}</th>
                        <th scope="col" class="th-price text-capitalize">{{ __('t.price') ?? "price" }}</th>
                        <th scope="col" class="th-orders text-capitalize"> {{ __('t.total') ?? "total" }} </th>
                        <th scope="col" class="th-role text-capitalize">{{ __('t.customer') ?? "customer" }}</th>
                        <th scope="col" class="th-date text-capitalize">{{ __('t.date') ?? "date" }}</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($orders as $item)
                        <tr class="list_sheet" data-orderid="{{ $item->order->id }}">
                            <td scope="row" class="px-2 list_sheet_id" data-orderid="{{ $item->order->id }}">
                                {{ $item->order->id }}</td>
                            <td class="px-2">{{ $item->product->name }}</td>
                            <td class="px-2">{{ $item->quantity }}</td>
                            <td class="px-2">{{ $item->product->price  }} <small>@setting('currency')</small> </td>
                            <td class="px-2"> {{ number_format($item->product->price * $item->quantity, 2) }}
                                <small>@setting('currency')</small> </td>
                            <td class="px-2">{{ $item->order->user->name }}</td>
                            <td class="px-2">{{ $item->order->created_at }}</td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

        {{ $orders->links() }}
    @else
        <div class="k-alert alert alert-secondary" role="alert">
            {{ __('t.no_data_found') ?? 'No products found.' }}
        </div>
    @endif


</x-layout>
