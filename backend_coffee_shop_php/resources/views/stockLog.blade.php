<x-layout title="stock log Page" name_page="stock-log">

    <!-- Button trigger modal -->
    <div class="d-flex justify-content-end mb-3">
        <a
            class="btn_add_to_stock btn btn-primary float-end btn-sm d-flex align-items-center text-capitalize"
            href="{{ route('stock.log.show.add.to.stock') }}"

            >
            <x-icon name="add" /> {{ __('t.add_new') ?? "add new" }}
        </a>
    </div>

    <div class="cont-table">
        @if ($stock_log->isNotEmpty())
            <table class="table table-bordered table-sm" data-bs-theme="dark">
                <thead>
                    <tr>
                        <th scope="col" class="th-id text-capitalize"> {{ __('t.id') ?? "id" }} </th>
                        <th scope="col" class="th-name text-capitalize"> {{ __('t.name') ?? "name" }} </th>
                        <th scope="col" class="th-quantity text-capitalize"> {{ __('t.quantity') ?? "quantity" }} </th>
                        <th scope="col" class="th-time text-capitalize"> {{ __('t.date') ?? "date" }} </th>
                        <th scope="col" class="th-user text-capitalize"> {{ __('t.user') ?? "user" }} </th>
                        <th scope="col" class="th-user text-capitalize"> {{ __('t.receipt_number') ?? "receipt number" }}
                        </th>
                        <th scope="col" class="th-user text-capitalize"> {{ __('t.receipt') ?? "receipt" }} </th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($stock_log as $sl)
                        <tr>
                            <th scope="row" class="px-2">{{ $sl->id }}</th>
                            <td class="px-2">{{ $sl->ingredient->name }}</td>
                            <td class="px-2">{{ $sl->quantity }} {{ $sl->ingredient->unit }}</td>
                            <td class="px-2">{{ $sl->created_at }}</td>
                            <td class="px-2">{{ $sl->user->name }}</td>
                            <td class="px-2">
                                @if ($sl->receipt)
                                    {{ $sl->receipt->number }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-2">
                                <div class="box-actions d-grid">
                                    @if ($sl->receipt && $sl->receipt->receipt_photo)
                                        <button class="btn-receipt btn btn-sm btn-primary text-capitalize"
                                            data-img="{{ asset($sl->receipt->receipt_photo) }}">
                                            {{ __('t.show_receipt') ?? "show receipt" }} </button>
                                    @else
                                        <span>-</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
            {{ $stock_log->links() }}
        @else
            <div class="box-alert">
                <div class="k-alert alert alert-secondary" role="alert">
                    There is nothing
                </div>
            </div>
        @endif
    </div>

    {{-- model photo receipt --}}

    <div class="modal fade" id="receiptModal" tabindex="-1" aria-labelledby="receiptModalLabel" aria-hidden="true"
        data-bs-theme="dark">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-capitalize" id="receiptModalLabel">
                        {{ __('t.receipt') ?? "receipt" }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="receiptImage" src="" alt="Receipt Image" class="img-fluid rounded shadow">
                </div>
            </div>
        </div>
    </div>





</x-layout>
