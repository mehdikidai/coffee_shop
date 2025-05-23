<x-layout title="product edit Page">
    <div class="page-product-edit container mt-3">
        <div class="box">
            <button class="back" id="btn_back_edit_product" onclick="history.back()">
                <x-icon name="arrow_back"/>
            </button>
            <h2 class="text-light">Update Product</h2>
        </div>

        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data"
            data-bs-theme="dark">
            @csrf
            @method('PUT')

            <div class="mb-3 mt-4 input-group-sm">
                <label for="name" class="form-label text-light mb-2">Name</label>
                <input type="text" class="form-control" value="{{ old('name', $product->name) }}" id="name"
                    placeholder="Enter Name" name="name">
            </div>

            <div class="mb-3 input-group-sm">
                <label for="price" class="form-label text-light mb-2">Price</label>
                <input type="number" class="form-control" id="price" placeholder="Enter Price" name="price"
                    value="{{ old('price', $product->price) }}">
            </div>

            <div class="mb-3 input-group-sm">
                <label for="category_id" class="form-label text-light">Category</label>
                <select class="form-select" name="category_id" aria-label="Default select example">
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3 input-group-sm">
                <label for="formFile" class="form-label text-light">Photo product</label>
                <input class="form-control" name="photo" type="file">
                <small class="text-muted">Leave blank to keep current photo.</small>
            </div>

            <div class="input-group-sm d-grid">
                <button type="submit" class="btn btn-primary mt-2">Update Product</button>
            </div>



        </form>
    </div>
</x-layout>
