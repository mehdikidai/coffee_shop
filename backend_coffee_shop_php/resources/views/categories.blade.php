<x-layout title="categories Page" name_page="page-categories">

    <!-- Button trigger modal -->
    <div class="btns">
        <button type="button"
            class="k-button-add-category btn btn-primary mb-3 float-end btn-sm d-flex align-items-center"
            data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            <x-icon name="add" /> {{ __('t.new_category') ?? "new category" }}
        </button>
    </div>


    @if($categories->isNotEmpty())

        <div class="cont-table">
            <table class="table table-bordered table-sm" data-bs-theme="dark">
                <thead>
                    <tr>
                        <th scope="col" class="th-order-id text-capitalize"> {{ __('t.id') ?? "id" }} </th>
                        <th scope="col" class="th-order-name text-capitalize"> {{ __('t.name') ?? "name" }} </th>
                        <th scope="col" class="th-order-name text-capitalize"> {{ __('t.index') ?? "index" }} </th>
                        <th scope="col" class="th-order-name text-capitalize"> {{ __('t.products') ?? "products" }} </th>
                        <th scope="col" class="th-actions text-capitalize"> {{ __('t.actions') ?? "actions" }} </th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($categories as $c)
                        <tr>
                            <th scope="row" class="px-2">{{ $c->id }}</th>
                            <td class="px-2">{{ $c->name }}</td>
                            <td class="px-2">{{ $c->index }}</td>
                            <td class="px-2">{{ $c->products->count() }}</td>
                            <td class="td-actions">
                                <div class="box-actions">
                                    <form class="form-delete-category" action="{{ route('categories.destroy', $c->id) }}"
                                        method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger text-capitalize">
                                            <x-icon name="delete" /> {{ __('t.delete') ?? "delete" }}
                                        </button>
                                    </form>
                                    <a href="{{ route('categories.edit', $c->id) }}" class="btn btn-sm btn-primary text-capitalize">
                                        <x-icon name="edit" /> {{ __('t.edit') ?? "edit" }}
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>


        {{ $categories->links() }}


    @else


        <div class="box-alert">
            <div class="k-alert alert alert-secondary" role="alert">
                There is nothing
            </div>
        </div>


    @endif


    {{-- model create --}}

    <div class="modal fade" data-bs-theme="dark" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-capitalize" id="staticBackdropLabel"> {{ __('t.add_new_category') ?? "add new category" }} </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('categories.store') }}" method="post">
                        @csrf
                        <div class="mb-3 input-group-sm">
                            <label for="exampleFormControlInput1" class="form-label text-capitalize"> {{ __('t.name_category') ?? "name category" }} </label>
                            <input type="text" name="name" class="form-control" placeholder="{{ __('t.name_category') ?? "name category" }}">
                        </div>
                        <div class="d-grid mt-4 input-group-sm">
                            <button type="submit" class="btn btn-primary text-capitalize"> {{ __('t.add_category') ?? "add category" }} </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- model create --}}


</x-layout>


<x-swal class_form=".form-delete-category"></x-swal>
