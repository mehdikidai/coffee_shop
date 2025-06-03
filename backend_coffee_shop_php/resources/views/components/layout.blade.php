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

    {{-- bootstrap --}}

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>

    @vite(['resources/css/app.scss', 'resources/css/bootstrap.css'])

</head>


<body class="app">

    <div class="sidebar">

        <div class="logo-box">
            <h2>coffee shop</h2>
        </div>
        <ul>
            <li><a href="{{ route('home') }}"><x-icon name="home" /> home</a></li>
            <li><a href="{{ route('users') }}"><x-icon name="person" />users</a></li>
            <li><a href="{{ route('products.index') }}"><x-icon name="package_2" />products</a></li>
            <li><a href="{{ route('orders.index') }}"><x-icon name="receipt" />orders</a></li>
            <li><a href="#"><x-icon name="logout" />logout</a></li>
        </ul>
    </div>

    <div class="main">
        <div class="header">
            <h1>welcome admin</h1>
            <div class="box-user">
                <span>mehdi</span>
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
