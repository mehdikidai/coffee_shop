<x-layout title="setting Page" name_page="setting mb-4">
    <h4 class="text-white text-capitalize"> {{ __('t.setting') ?? "setting" }} </h4>
    <ul class="list-group list-group-flush mt-4" data-bs-theme="dark">
        <li class="list-group-item bg-transparent text-capitalize d-flex justify-content-between align-items-center">
            {{ __('t.language') }}
            <div class="dropdown">
                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    {{ __('t.select_language') }}
                </button>
                <ul class="dropdown-menu">
                    @foreach($languages as $code => $language)
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-1" href="{{ route('setting.lang', ['locale' => $code]) }}">
                                <img src="{{ $language['flag'] }}" alt="{{ $language['name'] }}" width="18">
                                {{ $language['name'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </li>
        <li class="list-group-item bg-transparent text-capitalize">Other setting 1</li>
        <li class="list-group-item bg-transparent text-capitalize">Other setting 2</li>
    </ul>
</x-layout>
