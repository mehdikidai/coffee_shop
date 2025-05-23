<x-layout title="Home Page">
    <div class="page-users">


        @if(session('success'))
            <div class="k-alert alert alert-success" role="alert">
                {{ session('success') }}
                <button class="btns_remove_alert">
                    <x-icon name="close" />
                </button>
            </div>
        @endif

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="k-alert alert alert-danger" role="alert">
                    {{ $error }}
                    <button class="btns_remove_alert">
                        <x-icon name="close" />
                    </button>
                </div>
            @endforeach
        @endif


        <!-- Button trigger modal -->
        <button type="button" class="k-button-add-user btn btn-primary mb-3 float-end btn-sm d-flex align-items-center"
            data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            <x-icon name="add" /> Add New User
        </button>


        <table class="table table-bordered table-sm" data-bs-theme="dark">
            <thead>
                <tr>
                    <th scope="col" class="th-id">#</th>
                    <th scope="col" class="th-name">Name</th>
                    <th scope="col" class="th-email">Email</th>
                    <th scope="col" class="th-role">Role</th>
                    <th scope="col" class="th-orders">Orders</th>
                    <th scope="col" class="th-actions">Actions</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($users as $user)
                    <tr>
                        <th scope="row" class="px-2">{{ $user->id }}</th>
                        <td class="px-2">{{ $user->name }}</td>
                        <td class="px-2">{{ $user->email }}</td>
                        <td class="px-2">{{ $user->role }}</td>
                        <td class="px-2"> {{ $user->orders_count }} </td>
                        <td class="td-actions">
                            <div class="box-actions">
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-primary">
                                    <x-icon name="edit" /> Edit
                                </a>
                                <form class="form-delete-user" action="{{ route('users.destroy', $user->id) }}"
                                    method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        <x-icon name="delete" /> Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>



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
        <div class="modal fade" data-bs-theme="dark" id="staticBackdrop" data-bs-backdrop="static"
            data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Add New User</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('users.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3 input-group-sm">
                                <label for="exampleFormControlInput1" class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="name@example.com">
                            </div>
                            <div class="mb-3 input-group-sm">
                                <label for="exampleFormControlInput1" class="form-label">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="100">
                            </div>
                            <div class="mb-3 input-group-sm">
                                <label for="exampleFormControlInput1" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="password">
                            </div>

                            {{-- <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Category</label>


                                <select class="form-select" name="category_id" aria-label="Default select example">

                                    <option selected>Select category</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name}}</option>
                                    @endforeach


                                </select>


                            </div> --}}


                            <div class="d-grid mt-4 input-group-sm">
                                <button type="submit" class="btn btn-primary">Add User</button>
                            </div>



                        </form>
                    </div>
                </div>
            </div>
        </div>







    </div>

</x-layout>
