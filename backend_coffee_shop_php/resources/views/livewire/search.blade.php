<div class="search" data-bs-theme="dark">

    <span class="input-txt" id="visible-addon">
        <x-icon name="search" />
    </span>
    <input type="text" class="form-control" placeholder=" {{ __('t.search') }} " wire:model.live="search">

    @if(!empty($search))
        <ul class="list-search">
            @forelse($results as $result)
                <li class="list-group-item">
                    <a href=" {{ route("products.edit", $result->id) }} " class="text-white">{{ $result->name }}</a>
                </li>
            @empty
                <li class="list-group-item text-white">No results found.</li>
            @endforelse
        </ul>
    @endif


</div>
