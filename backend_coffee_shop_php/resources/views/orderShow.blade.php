<x-layout title="show orders Page" name_page="page-show-order">

    <x-only-admin>

        <div class="box-container">
            <div class="box box-items">
                <div class="btn-and-title">
                    <a href="{{ url()->previous() }}">
                        @if (app()->getLocale() === 'ar')
                            <x-icon name="arrow_forward" />
                        @else
                            <x-icon name="arrow_back" />
                        @endif
                    </a>
                    <h2 class="box-tit"> {{ __('t.list_items') }} </h2>
                </div>
                <table class="table table-bordered table-sm" data-bs-theme="dark">
                    <thead>
                        <tr>
                            <th scope="col" class="th-order-id"> {{ __('t.product_id') }} </th>
                            <th scope="col" class="th-order-name">{{ __('t.name') ?? 'name' }} </th>
                            <th scope="col" class="th-quantity"> {{ __('t.quantity') ?? 'quantity' }} </th>
                            <th scope="col" class="th-total"> {{ __('t.price') ?? 'price' }} </th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($order->items as $item)
                            <tr>
                                <th scope="row" class="px-2">{{ $item->id }}</th>
                                <td class="px-2">{{ $item->product->name }}</td>
                                <td class="px-2">{{ $item->quantity }}</td>
                                <td class="px-2">{{ number_format($item->product->price ?? 0, 2) }}
                                    <small>{{ config('setting.currency') }}</small>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
            <div class="box box-total">
                <div class="btn-and-title">
                    <h2 class="box-tit"> {{ __('t.total_order') ?? 'total order' }} </h2>
                </div>
                <div class="total">
                    <table class="table table-sm" data-bs-theme="dark">
                        {{-- <thead>
                            <tr>
                                <th scope="col" class="th-order-id">Product Id</th>
                                <th scope="col" class="th-order-name">Name</th>
                            </tr>
                        </thead> --}}
                        <tbody>

                            <tr>
                                <th scope="row" class="px-2"> {{ __('t.user_name') ?? 'user name' }} </th>
                                <td class="px-2">{{ $order->user->name }}</td>
                            </tr>
                            <tr>
                                <th scope="row" class="px-2"> {{ __('t.order_id') ?? 'order id' }} </th>
                                <td class="px-2">{{ $order->id }}</td>
                            </tr>
                            <tr>
                                <th scope="row" class="px-2">{{ __('t.date') ?? 'date' }} </th>
                                <td class="px-2">{{ $order->created_at->format('d/m/Y')}}</td>
                            </tr>
                            <tr>
                                <th scope="row" class="px-2">{{ __('t.time') ?? 'time' }} </th>
                                <td class="px-2">{{ $order->created_at->format('H:i')}}</td>
                            </tr>
                            <tr>
                                <th scope="row" class="px-2"> {{ __('t.quantity') ?? 'quantity' }} </th>
                                <td class="px-2"> {{ $order->items->sum('quantity') }} </td>
                            </tr>
                            <tr>
                                <th scope="row" class="px-2"> {{ __('t.total') ?? 'total' }} </th>
                                <td class="px-2">
                                    {{ number_format($order->items->sum(fn($item) => $item->quantity * $item->product->price) ?? 0, 2) }}
                                    <small>{{ config('setting.currency') }}</small>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </x-only-admin>
</x-layout>
