<x-layout title="Setting Page" name_page="setting mb-4">
    <h4 class="text-white text-capitalize"> {{ __('t.setting') ?? "Setting" }} </h4>

    <ul class="list-group list-group-flush mt-4 ul-setting-language" data-bs-theme="dark">
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
                            <a class="dropdown-item d-flex align-items-center gap-1"
                                href="{{ route('setting.lang', ['locale' => $code]) }}">
                                <img src="{{ $language['flag'] }}" alt="{{ $language['name'] }}" width="18">
                                {{ $language['name'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </li>
    </ul>

    <div class="border-top mt-4" data-bs-theme="dark"></div>

    <form action="{{ route('setting.update') }}" method="POST" class="mt-3">
        @csrf
        @method('PUT')

        <ul class="list-group list-group-flush" data-bs-theme="dark">
            <li class="list-group-item bg-transparent text-capitalize border-0">
                <div class="input-group-sm">
                    <label for="site_name" class="form-label opacity-75"> {{ __('t.site_name') ?? "site name" }} </label>
                    <input type="text" class="form-control" id="site_name" name="site_name" placeholder="{{ __('t.site_name') ?? "site name" }}"
                        value="{{ old('site_name', setting('site_name', '')) }}">
                </div>
            </li>
            <li class="list-group-item bg-transparent text-capitalize border-0">
                <div class="input-group-sm">
                    <label for="site_email" class="form-label opacity-75"> {{ __('t.site_email') ?? "site email" }} </label>
                    <input type="email" class="form-control" id="site_email" name="site_email" placeholder="{{ __('t.site_email') ?? "site email" }}"
                        value="{{ old('site_email', setting('site_email', '')) }}">
                </div>
            </li>
            <li class="list-group-item bg-transparent text-capitalize border-0">
                <div class="input-group-sm">
                    <label for="daily_expected_income" class="form-label opacity-75"> {{ __('t.daily_expected_income') ?? "daily expected income" }} </label>
                    <input type="number" step="0.01" class="form-control" id="daily_expected_income" name="daily_expected_income" placeholder="{{ __('t.daily_expected_income') ?? "daily expected income" }}"
                        value="{{ old('daily_expected_income', setting('daily_expected_income', '')) }}">
                </div>
            </li>


            <li class="list-group-item bg-transparent text-capitalize border-0">
                <div class="input-group-sm">
                    <label for="daily_expected_income" class="form-label opacity-75"> {{ __('t.pagination_limit') ?? "pagination limit" }} </label>
                    <input type="number" step="0.01" class="form-control" id="daily_expected_income" name="pagination_limit" placeholder="{{ __('t.daily_expected_income') ?? "daily expected income" }}"
                        value="{{ old('pagination_limit', setting('pagination_limit', '')) }}">
                </div>
            </li>

            <li class="list-group-item bg-transparent text-capitalize border-0">
                <div class="mb-1 input-group-sm">
                    <label for="currency" class="form-label opacity-75"> {{ __('t.currency') ?? "currency" }} </label>
                    <input type="text" class="form-control ltr" id="currency" name="currency" placeholder=" {{ __('t.currency') ?? "currency" }} "
                        value="{{ old('currency', setting('currency', '$')) }}">
                </div>
            </li>
        </ul>

        <div class="mt-4 input-group-sm d-flex">
            <button type="submit" class="btn btn-primary"> {{ __('t.save_settings') ?? 'Save Settings' }} </button>
        </div>
    </form>
</x-layout>
