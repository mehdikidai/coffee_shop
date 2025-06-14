<x-layout title="setting Page" name_page="setting">
    <h4 class="text-white text-capitalize"> {{ __('t.setting') ?? "setting" }} </h4>
    <ul class="list-group list-group-flush mt-4" data-bs-theme="dark">
        <li class="list-group-item bg-transparent text-capitalize d-flex justify-content-between align-items-center">
            Language
            <div class="dropdown">
                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    Select language
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('setting.lang', ['locale' => 'en']) }}">English</a></li>
                    <li><a class="dropdown-item" href="{{ route('setting.lang', ['locale' => 'fr']) }}">French</a></li>
                </ul>
            </div>
        </li>
        <li class="list-group-item bg-transparent text-capitalize">Other setting 1</li>
        <li class="list-group-item bg-transparent text-capitalize">Other setting 2</li>
    </ul>

</x-layout>
