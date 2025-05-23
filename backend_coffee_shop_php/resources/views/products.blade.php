<x-layout title="product Page">
    <div class="page-product">




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
        <button type="button"
            class="k-button-add-product btn btn-primary mb-3 float-end btn-sm d-flex align-items-center"
            data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            <x-icon name="add" /> Add New Product
        </button>



        <table class="table table-bordered table-sm" data-bs-theme="dark">
            <thead>
                <tr>
                    <th scope="col" class="th-id">#</th>
                    <th scope="col" class="th-name">Name</th>
                    <th scope="col" class="th-price">Price</th>
                    <th scope="col" class="th-category">Category</th>
                    <th scope="col" class="th-photo">Photo</th>
                    <th scope="col" class="th-actions">Actions</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($products as $product)
                    <tr>
                        <th scope="row" class="px-2">{{ $product->id }}</th>
                        <td class="px-2">{{ $product->name }}</td>
                        <td class="px-2">{{ $product->price }}</td>
                        <td class="px-2">{{ $product->category->name }}</td>
                        <td class="photo-product">
                            <img src="{{ $product->photo }}" alt="{{ $product->name }}">
                        </td>
                        <td class="td-actions">
                            <div class="box-actions">

                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-primary">
                                    <x-icon name="edit" /> Edit
                                </a>

                                <form action="{{ route('products.toggleVisibility', $product->id) }}" method="POST"
                                    style="display:inline-block;">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-sm btn-success">
                                        <x-icon name="{{ $product->visible ? 'visibility' : 'visibility_off'  }}" />
                                        {{ $product->visible ? 'hidden' : 'show' }}
                                    </button>
                                </form>
                                <form class="form-delete-product" action="{{ route('products.destroy', $product->id) }}"
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



        @if ($products->lastPage() > 1)
            <nav>
                <ul class="k-pagination">
                    @for ($i = 1; $i <= $products->lastPage(); $i++)
                        @if ($i == $products->currentPage())
                            <li class="page-item active"><span class="page-link">{{ $i }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $products->url($i) }}">{{ $i }}</a></li>
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
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Add New Product</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3 input-group-sm">
                                <label for="exampleFormControlInput1" class="form-label">Name product</label>
                                <input type="text" name="name" class="form-control" placeholder="name@example.com">
                            </div>
                            <div class="mb-3 input-group-sm">
                                <label for="exampleFormControlInput1" class="form-label">Price product</label>
                                <input type="number" name="price" class="form-control" placeholder="100">
                            </div>
                            <div class="mb-3 input-group-sm">
                                <label for="exampleFormControlInput1" class="form-label">Category</label>


                                <select class="form-select" name="category_id" aria-label="Default select example">

                                    <option selected>Select category</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name}}</option>
                                    @endforeach


                                </select>


                            </div>
                            <div class="mb-3 input-group-sm">
                                <label for="formFile" class="form-label">Photo product</label>
                                <input class="form-control" name="photo" type="file">
                            </div>

                            <div class="d-grid mt-4 input-group-sm">
                                <button type="submit" class="btn btn-primary">Add Product</button>
                            </div>



                        </form>
                    </div>
                </div>
            </div>
        </div>



    </div>

</x-layout>
