<x-layout title="product Page" name_page="page-product">

    <!-- Button trigger modal -->
    <button type="button"
        class="k-button-add-product btn btn-primary mb-3 float-end btn-sm d-flex align-items-center text-capitalize"
        data-bs-toggle="modal" data-bs-target="#staticBackdrop">
        <x-icon name="add" /> {{ __('t.new_product') ?? "new product" }}
    </button>

    <div class="cont-table">
        <table class="table table-bordered table-sm" data-bs-theme="dark">
            <thead>
                <tr>
                    <th scope="col" class="th-id text-capitalize"> {{ __('t.id') ?? "id" }} </th>
                    <th scope="col" class="th-name text-capitalize"> {{ __('t.name') ?? "name" }} </th>
                    <th scope="col" class="th-price text-capitalize"> {{ __('t.price') ?? "price" }} </th>
                    <th scope="col" class="th-category text-capitalize"> {{ __('t.ingredients') ?? "ingredients" }}</th>
                    <th scope="col" class="th-category text-capitalize"> {{ __('t.category') ?? "category" }} </th>
                    <th scope="col" class="th-photo text-capitalize"> {{ __('t.photo') ?? "photo" }} </th>
                    <th scope="col" class="th-actions text-capitalize"> {{ __('t.actions') ?? "actions" }} </th>
                </tr>
            </thead>
            <tbody>

                @foreach ($products as $product)
                    <tr>
                        <th scope="row" class="px-2">{{ $product->id }}</th>
                        <td class="px-2">{{ $product->name }}</td>
                        <td class="px-2">{{ $product->price }}</td>
                        <td class="px-2">
                            @foreach ($product->ingredients as $in)
                                <small>{{ $in->name }} ({{ $in->pivot->quantity }})</small>
                                @if (!$loop->last)
                                    <span class="break">|</span>
                                @endif
                            @endforeach
                        </td>
                        <td class="px-2">{{ $product->category->name }}</td>
                        <td class="photo-product">
                            <img src="{{ $product->photo }}" alt="{{ $product->name }}">
                        </td>
                        <td class="td-actions">
                            <div class="box-actions">

                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-primary">
                                    <x-icon name="edit" /> {{ __('t.edit') ?? "edit" }}
                                </a>

                                <form action="{{ route('products.toggleVisibility', $product->id) }}" method="POST"
                                    style="display:inline-block;">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-sm btn-success">
                                        <x-icon name="{{ $product->visible ? 'visibility' : 'visibility_off'  }}" />
                                        {{ $product->visible ? __('t.hidden') : __('t.show') }}
                                    </button>
                                </form>
                                <form class="form-delete-product" action="{{ route('products.destroy', $product->id) }}"
                                    method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
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

     {{ $products->links() }}

    <!-- Modal -->
    <div class="modal fade" data-bs-theme="dark" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-capitalize" id="staticBackdropLabel">
                        {{ __('t.add_new_product') ?? "add new product" }} </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3 input-group-sm">
                            <label for="exampleFormControlInput1" class="form-label text-capitalize">
                                {{ __('t.name_product') ?? "name product" }} </label>
                            <input type="text" name="name" class="form-control" placeholder="name@example.com">
                        </div>
                        <div class="mb-3 input-group-sm">
                            <label for="exampleFormControlInput1" class="form-label text-capitalize">
                                {{ __('t.price_product') ?? "price product" }} </label>
                            <input type="number" name="price" class="form-control" placeholder="100">
                        </div>
                        <div class="mb-3 input-group-sm">
                            <label for="exampleFormControlInput1" class="form-label text-capitalize">
                                {{ __('t.category') ?? "category" }} </label>


                            <select class="form-select" name="category_id" aria-label="Default select example">

                                <option selected> {{ __('t.select_category') ?? "select category" }} </option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name}}</option>
                                @endforeach


                            </select>


                        </div>
                        <div class="mb-3 input-group-sm">
                            <label for="formFile" class="form-label text-capitalize"> {{ __('t.photo') ?? "photo" }}
                            </label>
                            <input class="form-control" name="photo" type="file">
                        </div>

                        <div class="d-grid mt-4 input-group-sm">
                            <button type="submit" class="btn btn-primary text-capitalize">
                                {{ __('t.add_product') ?? "add product" }} </button>
                        </div>



                    </form>
                </div>
            </div>
        </div>
    </div>





</x-layout>
