<x-layout-login title="Login Page" name_page="page-login-box">

    <div class="page-login {{ app()->getLocale() === "ar" ? 'arabic' : '' }}">
        <div class="box box_one">
            <img src="{{ asset('imgs/bg-beecoffee-login.jpg') }}" alt="bg bee coffee login">
            <div class="box_override"></div>
        </div>
        <div class="box box_two">
            <div class="container-login" data-bs-theme="dark">

                <form class="form-login" method="post" action="{{ route('auth.login') }}" data-bs-theme="dark">
                    @csrf
                    <div class="form-group mb-4">
                        <h1 class="text-white">{{ $app_name }}</h1>
                    </div>
                    <div class="form-group mb-2">
                        <label for="exampleInputEmail1" class="text-white mb-1">
                            {{ __('t.email_address') ?? 'email address' }} </label>
                        <input type="email" name="email" class="form-control" placeholder="example@mail.com"
                            value="{{ old("email") }}">
                        @error('email')
                            <small class="invalid-feedback d-block">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="exampleInputPassword1" class="text-white mb-1"> {{ __('t.password') ?? 'password' }}
                        </label>
                        <input type="password" name="password" class="form-control" placeholder="password">
                        @error('password')
                            <small class="invalid-feedback d-block">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-check text-start my-3">
                        <input class="form-check-input" type="checkbox" value="remember_me" name="remember_me"
                            id="checkDefault">
                        <label class="form-check-label text-white" for="checkDefault">
                            {{ __('t.remember_me') ?? 'remember_me' }} </label>
                    </div>
                    <div class="form-group mb-3 d-grid">
                        <button type="submit" class="btn btn-primary"> {{ __('t.login') ?? 'login' }} </button>
                    </div>
                </form>

            </div>
            <ul class="language_ul">
                @foreach($languages as $code => $language)
                    <li class="d-inline">
                        <a class="dropdown-item d-inline align-items-center gap-1"
                            href="{{ route('setting.lang', ['locale' => $code]) }}">
                            {{ $language['name'] }}
                        </a>
                    </li>
                    @if (!$loop->last)
                        <small>|</small>
                    @endif
                @endforeach
            </ul>



        </div>

    </div>

</x-layout-login>
