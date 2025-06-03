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
