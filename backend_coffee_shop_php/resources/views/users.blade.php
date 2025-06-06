<x-layout title="Home Page" name_page="page-users">


    <!-- Button trigger modal -->
    <button type="button"
        class="k-button-add-user btn btn-primary mb-3 float-end btn-sm d-flex align-items-center text-capitalize"
        data-bs-toggle="modal" data-bs-target="#staticBackdrop">
        <x-icon name="add" /> {{ __('t.new_user') ?? "new user" }}
    </button>

    <div class="cont-table">
        <table class="table table-bordered table-sm" data-bs-theme="dark">
            <thead>
                <tr>
                    <th scope="col" class="th-id text-capitalize">id</th>
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
                        <td class="px-2">{{ $user->role }}</td>
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
                            </div>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>






    @if ($users->lastPage() > 1)
        <nav>
            <ul class="k-pagination">
                {{-- Page Number Links --}}
                @for ($i = 1; $i <= $users->lastPage(); $i++)
                    @if ($i == $users->currentPage())
                        <li class="page-item active"><span class="page-link">{{ $i }}</span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $users->url($i) }}">{{ $i }}</a></li>
                    @endif
                @endfor
            </ul>
        </nav>
    @endif


    <!-- Modal -->
    <div class="modal fade" data-bs-theme="dark" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-capitalize" id="staticBackdropLabel">
                        {{ __('t.add_new_user') ?? "add new user" }} </h1>
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



</x-layout>
