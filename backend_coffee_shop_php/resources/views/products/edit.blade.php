<x-layout title="product edit Page" name_page="page-product-edit container mt-3">

    <x-title-edit :text="__('t.update_product')"></x-title-edit>

    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data"
        data-bs-theme="dark">
        @csrf
        @method('PUT')

        <div class="mb-3 mt-4 input-group-sm">
            <label for="name" class="form-label text-light mb-2"> {{ __('t.name') ?? "name" }} </label>
            <input type="text" class="form-control" value="{{ old('name', $product->name) }}" id="name"
                placeholder="Enter Name" name="name">
        </div>

        <div class="mb-3 input-group-sm">
            <label for="price" class="form-label text-light mb-2"> {{ __('t.price') ?? "price" }} </label>
            <input type="text" class="form-control" id="price" placeholder="Enter Price" name="price"
                value="{{ old('price', $product->price) }}">
        </div>

        <div class="mb-3 input-group-sm">
            <label for="category_id" class="form-label text-light"> {{ __('t.category') ?? "category" }} </label>
            <select class="form-select" name="category_id" aria-label="Default select example">
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        @if (!empty($oldIngredients) && is_array($oldIngredients))
            <div id="ingredients-wrapper">
                <label for="ingredients" class="form-label text-light mb-2 text-capitalize">  {{ __('t.ingredients') ?? "ingredients" }}  </label>
                @foreach ($oldIngredients as $index => $old)
                    <div class="ingredient-group input-group-sm d-flex gap-2 mb-2" data-index="{{ $index }}">
                        <select name="ingredients[{{ $index }}][id]" class="form-select text-capitalize">
                            <option value=""> {{ __('t.select_the_component') ?? "select the component" }} </option>
                            @foreach($ingredients as $ingredient)
                                <option value="{{ $ingredient->id }}" {{ $old['id'] == $ingredient->id ? 'selected' : '' }}>
                                    {{ $ingredient->name }}
                                </option>
                            @endforeach
                        </select>

                        <input type="text" name="ingredients[{{ $index }}][quantity]" class="form-control"
                            value="{{ $old['quantity'] }}"
                            placeholder=" {{ __('t.quantity') ?? "quantity" }} ">
                        <button type="button" class="btn btn-danger btn-sm remove-ingredient text-capitalize">
                            {{ __('t.delete') }} </button>
                    </div>
                @endforeach
            </div>
        @endif





        <div class="input-group-sm mb-2">
            <label for="ingredients" class="form-label text-light mb-2 text-capitalize"> {{ __('t.new_ingredient') ?? "new ingredient" }} </label>
            <div>
                <div class="input-group-sm input-group-sm d-flex gap-2 mb-2">
                    <select name="ingredients[{{ count($oldIngredients) }}][id]" class="form-select text-capitalize">
                        <option value="" selected>select the ingredients</option>
                        @foreach($ingredients as $ingredient)
                            <option value="{{ $ingredient->id }}">
                                {{ $ingredient->name }} | {{ $ingredient->unit_name }}
                            </option>
                        @endforeach
                    </select>

                    <input type="text" name="ingredients[{{ count($oldIngredients) }}][quantity]" class="form-control"
                         placeholder="{{ __('t.quantity') ?? "Quantity" }}">
                </div>

            </div>
        </div>

        <div class="mb-3 input-group-sm">
            <label for="formFile" class="form-label text-light"> {{ __('t.photo_product') ?? "photo product" }} </label>
            <input class="form-control" name="photo" type="file">
            <small class="text-muted"> {{ __('t.leave_blank_to_keep_current_photo') ?? "leave blank to keep current photo" }} </small>
        </div>

        <div class="input-group-sm d-grid">
            <button type="submit" class="btn btn-primary mt-2"> {{ __('t.update_product') ?? "update product" }} </button>
        </div>

    </form>

</x-layout>
