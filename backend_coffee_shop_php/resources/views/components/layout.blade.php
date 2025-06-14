@props(['title' => 'dashboard', 'name_page'])


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    {{-- Material icon --}}
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />

    {{-- font google --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">


    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">

    {{-- bootstrap --}}

    @vite(['resources/css/app.scss', 'resources/css/bootstrap.css'])

</head>


<body class="app">

    <div class="sidebar" id="sidebar">

        <div class="logo-box">
            <h2>coffee shop</h2>
            <button class="k-btn-close" id="btn_close">
                <x-icon name="close" />
            </button>
        </div>
        <ul>
            <li class="{{ request()->routeIs('home') ? 'active' : '' }}">
                <a href="{{ route('home') }}">
                    <x-icon name="home" /> {{ __('nav.home') ?? "home"}}
                </a>
            </li>

            <li class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
                <a href="{{ route('users.index') }}">
                    <x-icon name="person" /> {{ __('nav.users') ?? "users" }}
                </a>
            </li>

            <li class="{{ request()->routeIs('products.*') ? 'active' : '' }}">
                <a href="{{ route('products.index') }}">
                    <x-icon name="package_2" /> {{ __('nav.products') ?? "products" }}
                </a>
            </li>

            <li class="{{ request()->routeIs('categories.*') ? 'active' : '' }}">
                <a href="{{ route('categories.index') }}">
                    <x-icon name="category" /> {{ __('nav.categories') ?? "categories" }}
                </a>
            </li>

            <li class="{{ request()->routeIs('ingredients.*') ? 'active' : '' }}">
                <a href="{{ route('ingredients.index') }}">
                    <x-icon name="shelves" /> ingredients
                </a>
            </li>


            <li class="{{ request()->routeIs('stock.log.*') ? 'active' : '' }}">
                <a href="{{ route('stock.log.index') }}">
                    <x-icon name="schedule" /> stock log
                </a>
            </li>


            <li class="{{ request()->routeIs('orders.*') ? 'active' : '' }}">
                <a href="{{ route('orders.index') }}">
                    <x-icon name="receipt" /> {{ __('nav.orders') ?? "orders" }}
                </a>
            </li>

             <li class="{{ request()->routeIs('setting.*') ? 'active' : '' }}">
                <a href="{{ route('setting.index') }}">
                    <x-icon name="settings" /> {{ __('t.setting') ?? "setting" }} 
                </a>
            </li>

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


    @vite(['resources/js/app.js'])

</body>

</html>
