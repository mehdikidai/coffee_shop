<x-layout title="Ingredients Page" name_page="page-ingredients">

    <!-- Button trigger modal -->
    <x-only-admin>
        <button type="button"
            class="k-button-add-product btn btn-primary mb-3 float-end btn-sm d-flex align-items-center text-capitalize px-3"
            data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            <x-icon name="add" /> {{ __('t.new_ingredient') ?? "new ingredient" }}
        </button>
    </x-only-admin>

    <div class="cont-table">
        <table class="table table-bordered table-sm" data-bs-theme="dark">
            <thead>
                <tr>
                    <th scope="col" class="th-id text-capitalize"> {{ __('t.id') ?? "id" }} </th>
                    <th scope="col" class="th-name text-capitalize"> {{ __('t.name') ?? "name" }} </th>
                    <th scope="col" class="th-unit text-capitalize"> {{ __('t.unit') ?? "unit" }} </th>
                    <th scope="col" class="th-unit text-capitalize"> {{ __('t.unit_name') ?? "unit_name" }} </th>
                    <th scope="col" class="th-stock text-capitalize"> {{ __('t.stock') ?? "stock" }} </th>
                    <x-only-admin>
                        <th scope="col" class="th-actions text-capitalize"> {{ __('t.actions') ?? "actions" }} </th>
                    </x-only-admin>
                </tr>
            </thead>
            <tbody>

                @foreach ($ingredients as $in)
                    <tr>
                        <th scope="row" class="px-2">{{ $in->id }}</th>
                        <td class="px-2 text-capitalize">{{ $in->name }}</td>
                        <td class="px-2 text-capitalize">{{ $in->unit }}</td>
                        <td class="px-2 text-capitalize">{{ $in->unit_name }}</td>
                        <td class="px-2 {{ $in->stock <= $in->stock_threshold ? 'text-danger fw-bold' : '' }}">
                            {{ $in->stock }} <small class="text-capitalize opacity-50">{{ $in->unit }}</small>
                        </td>
                        <x-only-admin>
                            <td class="td-actions">
                                <div class="box-actions">
                                    <a href="{{ route('ingredients.edit', $in->id) }}" class="btn btn-sm btn-primary">
                                        <x-icon name="edit" /> {{ __('t.edit') ?? "edit" }}
                                    </a>

                                    <a href="{{ route('ingredients.edit', $in->id) }}" class="btn btn-sm btn-success">
                                        <x-icon name="add" /> {{ __('t.add_stock') ?? "add stock" }}
                                    </a>

                                    <form class="form-delete-ingredient" id="destroy_ingredient"
                                        action="{{ route('ingredients.destroy', $in->id) }}" method="POST"
                                        style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">
                                            <x-icon name="delete" /> {{ __('t.delete') ?? "delete" }}
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </x-only-admin>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>

    {{ $ingredients->links() }}



    <!-- Modal -->
    <div class="modal fade" data-bs-theme="dark" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-capitalize" id="staticBackdropLabel">
                        {{ __('t.new_ingredient') ?? "new ingredient" }}
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('ingredients.store') }}" method="post">
                        @csrf

                        <div class="mb-3 input-group-sm">
                            <label for="name" class="form-label text-capitalize">
                                {{ __('t.name') ?? "name" }} </label>
                            <input type="text" name="name" value="{{ old("name") }}" class="form-control"
                                placeholder="Name Ingredient">
                        </div>

                        <div class="mb-3 input-group-sm">
                            <label for="unit" class="form-label text-capitalize">
                                {{ __('t.unit') ?? "unit" }} </label>
                            <input type="text" value="{{ old("unit") }}" name="unit" class="form-control"
                                placeholder="Unit">
                        </div>

                        <div class="mb-3 input-group-sm">
                            <label for="unit_name" class="form-label text-capitalize">
                                {{ __('t.unit_name') ?? "unit_name" }} </label>
                            <input type="text" value="{{ old('unit_name') }}" name="unit_name" class="form-control"
                                placeholder="Unit Name">
                        </div>

                        <div class="mb-3 input-group-sm">
                            <label for="stock" class="form-label text-capitalize">
                                {{ __('t.stock') ?? "stock" }} </label>
                            <input type="text" name="stock" value="{{ old('stock') }}" class="form-control"
                                placeholder="100">
                        </div>

                        <div class="mb-3 input-group-sm">
                            <label for="stock" class="form-label text-capitalize">
                                {{ __('t.stock_threshold') ?? "stock threshold" }} </label>
                            <input type="text" name="stock_threshold" value="{{ old('stock_threshold') }}"
                                class="form-control" placeholder="stock threshold">
                        </div>

                        <div class="mb-3 input-group-sm">
                            <label for="stock" class="form-label text-capitalize">
                                {{ __('t.price_per_unit') ?? "price_per_unit" }} </label>
                            <input type="text" name="price_per_unit" value="{{ old('price_per_unit') }}"
                                class="form-control" placeholder="price per unit">
                        </div>

                        <div class="d-grid mt-4 input-group-sm">
                            <button type="submit" class="btn btn-primary text-capitalize">
                                {{ __('t.add_ingredient') ?? "add ingredient" }} </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>


</x-layout>


<x-swal class_form=".form-delete-ingredient"></x-swal>
