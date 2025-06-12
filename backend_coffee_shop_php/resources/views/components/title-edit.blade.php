@props(['text' => 'Update Product'])

<div class="box box-title-edit">
    <button class="back" onclick="history.back()" type="button">
        <x-icon name="arrow_back" />
    </button>
    <h2 class="text-light"> {{ $text }} </h2>
</div>
