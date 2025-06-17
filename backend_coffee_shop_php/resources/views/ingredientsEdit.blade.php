<x-layout title="EditIngredients Page" name_page="page-edit-ingredients container mt-3">

    <x-title-edit :text="__('t.update_ingredient')"></x-title-edit>


    <form action="{{ route('ingredients.update', $ingredient->id) }}" method="POST" enctype="multipart/form-data"
        data-bs-theme="dark">
        @csrf
        @method('PUT')

        <div class="mb-3 mt-4 input-group-sm">
            <label for="name" class="form-label text-light text-capitalize">
                {{ __('t.name') ?? "name" }} </label>
            <input type="text" name="name" value="{{ old("name",$ingredient->name) }}" class="form-control" placeholder="Name Ingredient">
        </div>

        <div class="mb-3 input-group-sm">
            <label for="unit" class="form-label text-light text-capitalize">
                {{ __('t.unit') ?? "unit" }} </label>
            <input type="text" value="{{ old("unit",$ingredient->unit) }}" name="unit" class="form-control" placeholder="Unit">
        </div>

        <div class="mb-3 input-group-sm">
            <label for="unit_name" class="form-label text-light text-capitalize">
                {{ __('t.unit_name') ?? "unit_name" }} </label>
            <input type="text" value="{{ old('unit_name',$ingredient->unit_name) }}" name="unit_name" class="form-control"
                placeholder="Unit Name">
        </div>

        <div class="mb-3 input-group-sm">
            <label for="stock" class="form-label text-light text-capitalize">
                {{ __('t.stock') ?? "stock" }} </label>
            <input type="text" name="stock" value="{{ old('stock',$ingredient->stock) }}" class="form-control" placeholder="100">
        </div>

        <div class="mb-3 input-group-sm">
            <label for="stock" class="form-label text-light text-capitalize">
                {{ __('t.stock_threshold') ?? "stock threshold" }} </label>
            <input type="text" name="stock_threshold" value="{{ old('stock_threshold',$ingredient->stock_threshold) }}" class="form-control"
                placeholder="stock threshold">
        </div>

        <div class="mb-3 input-group-sm">
            <label for="stock" class="form-label text-light text-capitalize">
                {{ __('t.price_per_unit') ?? "price_per_unit" }} </label>
            <input type="text" name="price_per_unit" value="{{ old('price_per_unit',$ingredient->price_per_unit) }}" class="form-control"
                placeholder="price per unit">
        </div>

        <div class="d-grid mt-4 input-group-sm">
            <button type="submit" class="btn btn-primary text-capitalize">
                {{ __('t.update_ingredient') ?? "update ingredient" }} </button>
        </div>

    </form>


</x-layout>
