<x-layout-login title="Login Page" name_page="page-login">

    <x-alert></x-alert>

    <div class="box box_one">
        <img src="{{ asset('imgs/bg-beecoffee-login.jpg') }}" alt="bg bee coffee login">
        <div class="box_override"></div>
    </div>
    <div class="box box_two">
        <div class="container-login" data-bs-theme="dark">

            <form class="form-login" method="post" action="{{ route('auth.login') }}" data-bs-theme="dark">
                @csrf
                <div class="form-group mb-4">
                    <h1 class="text-white">{{ config('setting.site_name') }}</h1>
                </div>
                <div class="form-group mb-2">
                    <label for="exampleInputEmail1" class="text-white mb-1">Email address</label>
                    <input type="email" name="email" class="form-control" placeholder="Enter email"
                        value="{{ old("email") }}">
                </div>
                <div class="form-group mb-3">
                    <label for="exampleInputPassword1" class="text-white mb-1">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Password">
                </div>
                <div class="form-check text-start my-3">
                    <input class="form-check-input" type="checkbox" value="remember_me" name="remember_me" id="checkDefault">
                    <label class="form-check-label text-white" for="checkDefault">Remember me</label>
                </div>
                <div class="form-group mb-3 d-grid">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
            </form>

        </div>
    </div>


</x-layout-login>


