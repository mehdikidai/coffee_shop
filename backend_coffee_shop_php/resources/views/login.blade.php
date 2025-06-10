<x-layout-login title="Login Page" name_page="page-login">

    <x-alert></x-alert>

    <div class="container-login" data-bs-theme="dark">
        <form class="form-login" method="post" action="{{ route('auth.login') }}">
            @csrf
            <div class="form-group mb-4">
                <h1 class="text-white">welcome back</h1>
            </div>
            <div class="form-group mb-2">
                <label for="exampleInputEmail1" class="text-white mb-1">Email address</label>
                <input type="email" name="email" class="form-control" placeholder="Enter email" value="{{ old("email") }}">
            </div>
            <div class="form-group mb-3">
                <label for="exampleInputPassword1" class="text-white mb-1">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Password">
            </div>
            <div class="form-group mb-3 d-grid">
                <button type="submit" class="btn btn-primary">Login</button>
            </div>
        </form>
    </div>

</x-layout-login>
