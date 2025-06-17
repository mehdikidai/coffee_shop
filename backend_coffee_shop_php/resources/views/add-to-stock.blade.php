<x-layout title="add to stock Page" name_page="add-to-stock">

    <div class="container mt-2 mb-4">

        <h3 class="text-light mb-3 text-capitalize"> {{ __('t.add_to_stock') ?? "add to stock" }} </h3>

        <form action="{{ route('stock.log.store') }}" method="post" enctype="multipart/form-data" data-bs-theme="dark">
            
            @csrf

            <div id="ingredients-wrapper">
                <div class="ingredient-item mb-3 border rounded p-4 pt-4">
                    <div class="mb-3 input-group-sm">
                        <label class="form-label text-capitalize text-light">{{ __('t.ingredient') ?? 'ingredient' }}</label>
                        <select class="form-select" name="ingredients[0][ingredient_id]">
                            <option selected disabled> {{ __('t.select_ingredients') ?? "select ingredients" }} </option>
                            @foreach ($ingredients as $ing)
                                <option value="{{ $ing->id }}">{{ $ing->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3 input-group-sm">
                        <label class="form-label text-capitalize text-light">{{ __('t.quantity') ?? 'quantity' }}</label>
                        <input type="text" name="ingredients[0][quantity]" class="form-control" placeholder="{{ __('t.quantity') ?? 'quantity' }}">
                    </div>

                    <button type="button" class="remove-ingredient">
                        <x-icon name="close"></x-icon>
                    </button>
                </div>
            </div>

            <button type="button" class="btn btn_add_ingredient btn-sm my-2" id="add-ingredient">
                {{ __('t.add_ingredient') ?? 'add another ingredient' }}
            </button>

            <div class="mb-3 input-group-sm mt-3">
                <label class="form-label text-capitalize">{{ __('t.receipt') ?? "receipt" }}</label>
                <input class="form-control" name="receipt_photo" type="file">
            </div>

            <div class="d-grid mt-4 input-group-sm">
                <button type="submit" class="btn btn-primary text-capitalize">
                    {{ __('t.add_to_stock') ?? "add to stock" }}
                </button>
            </div>
        </form>

    </div>



</x-layout>
