@props(['title' => 'dashboard', 'name_page'])


<!DOCTYPE html>

<html lang="{{ app()->getLocale() }}" @if(app()->getLocale() === 'ar') dir="rtl" @endif>

<head>
    <meta charset="UTF-8">
    <meta name="robots" content="noindex, nofollow">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <title>{{ $title }}</title>
    {{-- Material icon --}}
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />

    {{-- font google --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    @if (app()->getLocale() === 'ar')

        <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Arabic:wght@100..900&display=swap" rel="stylesheet">
        @vite(['resources/css/app.scss', 'resources/css/bootstrap.rtl.min.css'])

    @else

        <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
        @vite(['resources/css/app.scss', 'resources/css/bootstrap.css'])


    @endif

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @livewireStyles

</head>


<body class="app">

    <div class="sidebar" id="sidebar">

        <div class="logo-box">
            <h2> @setting('site_name', 'name app') </h2>
            <button class="k-btn-close" id="btn_close">
                <x-icon name="close" />
            </button>
        </div>
        <ul>

            <x-nav-item route="home" route-is="home" icon="home" label="nav.home" />
            <x-nav-item route="users.index" route-is="users.*" icon="person" label="nav.users" />
            <x-nav-item route="products.index" route-is="products.*" icon="package_2" label="nav.products" />
            <x-nav-item route="categories.index" route-is="categories.*" icon="category" label="nav.categories" />
            <x-nav-item route="ingredients.index" route-is="ingredients.*" icon="shelves" label="nav.ingredients" />
            <x-nav-item route="stock.log.index" route-is="stock.log.*" icon="schedule" label="nav.stock_log" />
            <x-nav-item route="orders.index" route-is="orders.*" icon=" receipt" label="nav.orders" />
            <x-nav-item route="sheet.index" route-is="sheet.*" icon="checklist_rtl" label="nav.sheet" />
            <x-nav-item route="reviews.index" route-is="reviews.*" icon="inbox" label="nav.reviews" />
            <x-nav-item route="user-activity-logs.index" route-is="user-activity-logs.*" icon="history_2" label="nav.activity_log" />
            <x-nav-item route="setting.index" route-is="setting.*" icon="settings" label="t.setting" />

        </ul>

        <ul class="ul-logout">
            <li>
                <form action="{{ route('auth.logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-logout btn-link d-flex">
                        <x-icon name="logout" /> {{ __('nav.logout') ?? "logout"}}
                    </button>
                </form>
            </li>
        </ul>

    </div>

    <div class="main">
        <div class="header">
            <button id="btn_menu" class="btn_menu">
                <x-icon name="menu"></x-icon>
            </button>
            <h1> {{ __('t.welcome') ?? "welcome" }} {{ auth()->user()->name }}</h1>

            <x-only-admin>
                <livewire:search /> </x-only-admin>

                    <div class="box-user">
                        <div class="name-and-email">
                            <span>{{ auth()->user()->name }}</span>
                                <small>{{ auth()->user()->email }}</small>
                                </div>
                                <div class="photo">
                                    <img src="{{ asset('uploads/global/photo_profile.png') }}" alt="user">
                                </div>
                        </div>
                    </div>
                    <div class="content">
                        <div class="{{ $name_page }}">
                            <x-alert></x-alert>
                            {{ $slot }}
                        </div>

                            </div>
                    </div>
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
                        integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
                        crossorigin="anonymous"></script>

                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


                    @vite(['resources/js/app.js'])

                    @livewireScripts

</body>

</html>
