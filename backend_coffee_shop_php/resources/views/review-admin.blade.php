<x-layout title="Home Page" name_page="page-review">

    <x-only-admin>

        <div class="box-title box-title d-flex gap-3 justify-content-between mb-3" data-bs-theme="dark">


            <button type="button" class="btn btn-sm btn-primary px-3 text-capitalize d-flex align-items-center gap-2" data-bs-toggle="modal"
                data-bs-target="#qrCodeReviewModal">
                <x-icon name="qr_code" />
                {{ __('t.open_qr_code_review') ?? 'Open QR' }}
            </button>

            <form method="get">
                <div class="d-flex input-group-sm gap-2">
                    <input class="form-control" type="text" value="{{ request('search') }}" name="search" id="search"
                        placeholder="{{ __('t.search') ?? 'search' }}">
                    <button class="btn btn-sm btn-primary px-3"> {{ __('t.search') ?? 'search' }} </button>
                </div>
            </form>
        </div>

        @if ($reviews->count() > 0)
            <div class="cont-table">
                <table class="table table-bordered table-sm" data-bs-theme="dark">
                    <thead>
                        <tr>
                            <th scope="col" class="th-name text-capitalize">{{ __('t.name') ?? "name" }}</th>
                            <th scope="col" class="th-phone text-capitalize">{{ __('t.phone') ?? "phone" }}</th>
                            <th scope="col" class="th-comment text-capitalize">{{ __('t.comment') ?? "comment" }}</th>
                            <th scope="col" class="th-star text-capitalize">{{ __('t.stars') ?? "stars" }}</th>
                            <th scope="col" class="th-date text-capitalize">{{ __('t.date') ?? "date" }}</th>
                            <th scope="col" class="th-date text-capitalize">{{ __('t.time') ?? "time" }}</th>
                            <th scope="col" class="th-actions text-capitalize">{{ __('t.actions') ?? "actions" }} </th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($reviews as $review)
                            <tr>
                                <td class="px-2">{{ $review->name }}</td>
                                <td class="px-2 td-phone">{{ $review->phone ?? '-' }}</td>
                                <td class="px-2">{{ $review->comment }}</td>
                                <td class="px-2">
                                    @for ($i = 1; $i <= $review->rating; $i++)
                                        <span style="color: #fada7a;">★</span>
                                    @endfor


                                    @for ($i = 1; $i <= (5 - $review->rating); $i++)
                                        <span style="color: #8a9394;">★</span>
                                    @endfor
                                </td>
                                <td class="px-2">{{ $review->created_at->format('d/m/Y') }}</td>
                                <td class="px-2">{{ $review->created_at->format('h:s') }}</td>
                                <td class="td-actions">
                                    <div class="box-actions">
                                        <form class="form-delete-review" action="{{ route('reviews.destroy', $review->id) }}"
                                            method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger text-capitalize">
                                                <x-icon name="delete" /> {{ __('t.delete') ?? "delete" }}
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

            {{ $reviews->links() }}
        @else
            <div class="alert alert-secondary mt-3 text-capitalize" role="alert">
                {{ __('t.no_data_found') ?? 'No data found.' }}
            </div>
        @endif


        <div class="modal fade model-qr-code-review" id="qrCodeReviewModal" tabindex="-1"
            aria-labelledby="qrCodeReviewModalLabel" aria-hidden="true" data-bs-theme="dark">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body p-3">
                        <img id="imgQrCodeReviewBtn" src="https://api.qrserver.com/v1/create-qr-code/?size=300x300&margin=10&data={{ route('reviews.create') }}"
                            alt="QR Code" class="img-fluid mb-3">
                        <button id="downloadQrCodeReviewBtn"
                            class="download-qr-code-btn btn btn-sm btn-sm btn-primary d-flex w-100 text-capitalize">
                            {{ __('t.download' ?? 'download') }} <x-icon name="arrow_downward" />
                        </button>
                    </div>


                </div>
            </div>
        </div>



    </x-only-admin>
</x-layout>


<x-swal class_form=".form-delete-review"></x-swal>
