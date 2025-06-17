@props(['text' => 'Update Product'])

<div class="box box-title-edit">
    <button class="back" onclick="history.back()" type="button">
        @if (app()->getLocale() === 'ar')
            <x-icon name="arrow_forward" />
        @else
            <x-icon name="arrow_back" />
        @endif
    </button>
    <h2 class="text-light"> {{ $text }} </h2>
</div>
