<x-layout title="orders Page" name_page="page-orders">


        <div class="filter filter-order">
            <form method="GET" class="d-flex gap-2 " data-bs-theme="dark">
                <div class="input-group input-group-sm">

                    <select name="user_id" id="user_id" class="form-select">
                        <option value="">All</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" @selected(request('user_id') == $user->id)>{{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="input-group input-group-sm">
                    <input class="form-control" type="text" name="date" id="input_filter" value="{{ request('date') }}"
                        placeholder="dd-mm-yyyy">
                </div>
                <div class="input-group-sm d-grid">
                    <button type="submit" class="btn btn-primary d-flex align-items-center gap-2 btn-filter"> <x-icon
                            name="event" /> Filter</button>
                </div>

            </form>
        </div>



    @if($orders->isNotEmpty())

        <table class="table table-bordered table-sm" data-bs-theme="dark">
            <thead>
                <tr>
                    <th scope="col" class="th-order-id">Order Id</th>
                    <th scope="col" class="th-order-name">Name</th>
                    <th scope="col" class="th-quantity">Quantity</th>
                    <th scope="col" class="th-total">Total</th>
                    <th scope="col" class="th-date">Date</th>
                    <th scope="col" class="th-actions">-</th>
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
                                <form class="form-delete-product" action="{{ route('orders.destroy', $order->id) }}"
                                    method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        <x-icon name="delete" /> Delete
                                    </button>
                                </form>
                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-primary">
                                    <x-icon name="list_alt" />Details
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>


    @else


        <div class="box-alert">
            <div class="k-alert alert alert-secondary" role="alert">
                There is nothing
            </div>
        </div>


    @endif



</x-layout>
