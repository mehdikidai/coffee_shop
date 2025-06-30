<x-layout title="Home Page" name_page="page-users">


    <div class="box-title d-flex justify-content-between" data-bs-theme="dark">
        <!-- Button trigger modal -->
        <button type="button"
            class="k-button-add-user btn btn-primary mb-3 float-end btn-sm d-flex align-items-center text-capitalize"
            data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            <x-icon name="add" /> {{ __('t.new_user') ?? "new user" }}
        </button>
        <form method="get">
            <div class="d-flex input-group-sm gap-2">
                <input class="form-control" type="text" value="{{ request('search') }}" name="search" id="search"
                    placeholder="{{ __('t.search') ?? 'search' }}">
                <button class="btn btn-sm btn-primary"> {{ __('t.search') ?? 'search' }} </button>
            </div>

        </form>
    </div>

    @if ($users->count() > 0)
        <div class="cont-table">
            <table class="table table-bordered table-sm" data-bs-theme="dark">
                <thead>
                    <tr>
                        <th scope="col" class="th-id text-capitalize">{{ __('t.id') ?? "id" }}</th>
                        <th scope="col" class="th-name text-capitalize">{{ __('t.name') ?? "name" }}</th>
                        <th scope="col" class="th-email text-capitalize">{{ __('t.email') ?? "email" }}</th>
                        <th scope="col" class="th-role text-capitalize">{{ __('t.role') ?? "role" }}</th>
                        <th scope="col" class="th-role text-capitalize">{{ __('t.table') ?? "table" }}</th>
                        <th scope="col" class="th-orders text-capitalize"> {{ __('t.orders') ?? "orders" }} </th>
                        <th scope="col" class="th-actions text-capitalize">{{ __('t.actions') ?? "actions" }} </th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($users as $user)
                        <tr>
                            <th scope="row" class="px-2">{{ $user->id }}</th>
                            <td class="px-2">{{ $user->name }}</td>
                            <td class="px-2">{{ $user->email }}</td>
                            <td class="px-2">{{ __("t.{$user->role}") ?? $user->role }}</td>
                            <td class="px-2">{{ $user->table_number > 0 ? $user->table_number : '-'  }}</td>
                            <td class="px-2"> {{ $user->orders_count }} </td>
                            <td class="td-actions">
                                <div class="box-actions">
                                    <a href="{{ route('users.edit', $user->id) }}"
                                        class="btn btn-sm btn-primary text-capitalize">
                                        <x-icon name="edit" /> {{ __('t.edit') ?? "edit" }}
                                    </a>

                                    <form action="{{ route('users.toggleBlocked', $user->id) }}" method="POST"
                                        style="display:inline-block;">
                                        @csrf
                                        @method('PATCH')
                                        <button class="btn btn-sm btn-success text-capitalize">

                                            {{ !$user->is_blocked ? __('t.blocked') : __('t.unblocked') }}

                                        </button>
                                    </form>

                                    <form class="form-delete-user" action="{{ route('users.destroy', $user->id) }}"
                                        method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger text-capitalize">
                                            <x-icon name="delete" /> {{ __('t.delete') ?? "delete" }}
                                        </button>
                                    </form>
                                    <button class="btn_qr_code btn btn-sm btn-primary text-capitalize"
                                        data-key="{{ $user->table_key }}" data-name="{{ $user->name }}">
                                        <x-icon name="qr_code" />
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

        {{ $users->links() }}
    @else
        <div class="alert alert-secondary mt-4 text-capitalize" role="alert">
            {{ __('t.no_data_found') ?? 'No products found.' }}
        </div>
    @endif

    <!-- Modal -->
    <div class="modal fade" data-bs-theme="dark" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-capitalize" id="staticBackdropLabel">
                        {{ __('t.add_new_user') ?? "add new user" }}
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('users.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3 input-group-sm">
                            <label for="exampleFormControlInput1"
                                class="form-label text-capitalize">{{ __('t.name') ?? "name" }}</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                                placeholder="{{ __('t.name') ?? "name" }}">
                        </div>
                        <div class="mb-3 input-group-sm">
                            <label for="exampleFormControlInput1"
                                class="form-label text-capitalize">{{ __('t.email') ?? "email" }}</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control"
                                placeholder="{{ __('t.email') ?? "email" }}">
                        </div>
                        <div class="mb-3 input-group-sm">
                            <label for="exampleFormControlInput1"
                                class="form-label text-capitalize">{{ __('t.password') ?? "password" }}</label>
                            <input type="password" name="password" class="form-control"
                                placeholder="{{ __('t.password') ?? "password" }}">
                        </div>

                        <div class="d-grid mt-4 input-group-sm">
                            <button type="submit" class="btn btn-primary text-capitalize">
                                {{ __('t.add_user') ?? "add user" }} </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal qr code -->
    <!-- Modal qr code -->
    <div class="modal fade" id="qrCodeModal" tabindex="-1" aria-labelledby="qrCodeModalLabel" aria-hidden="true"
        data-bs-theme="dark">
        <div class="modal-dialog modal-dialog-centered" style="width: fit-content;margin: 0 auto;">
            <div class="modal-content text-center">
                <div class="modal-header py-2 px-3 d-none">
                    <h6 class="modal-title" id="qrCodeModalLabel">QR Code</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        style="font-size: .8rem;"></button>
                </div>
                <div class="modal-body p-3 d-flex flex-column align-items-center">
                    <img id="qrCodeImage" src="" alt="QR Code" class="img-fluid mb-3" style="max-width: 100%;" />
                    <button id="downloadQrCodeBtn"
                        class="download-qr-code-btn btn btn-sm btn-sm btn-primary d-flex w-100 text-capitalize">
                        {{ __('t.download' ?? 'download') }} <x-icon name="arrow_downward" />
                    </button>
                </div>
            </div>
        </div>
    </div>




</x-layout>

<x-swal class_form=".form-delete-user"></x-swal>

