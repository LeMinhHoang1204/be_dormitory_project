{{--<head>    <link rel="stylesheet" href="{{ asset('css/login.css') }}">--}}
{{--</head>--}}
{{--<x-guest-layout>--}}

{{--    <!-- Session Status -->--}}
{{--    <x-auth-session-status class="mb-4" :status="session('status')" />--}}

{{--    <form method="POST" action="{{ route('login') }}">--}}
{{--        @csrf--}}

{{--        <!-- Email Address -->--}}
{{--        <div>--}}
{{--            <x-input-label for="email" :value="__('Email')" />--}}
{{--            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />--}}
{{--            <x-input-error :messages="$errors->get('email')" class="mt-2" />--}}
{{--        </div>--}}

{{--        <!-- Password -->--}}
{{--        <div class="mt-4">--}}
{{--            <x-input-label for="password" :value="__('Password')" />--}}

{{--            <x-text-input id="password" class="block mt-1 w-full"--}}
{{--                            type="password"--}}
{{--                            name="password"--}}
{{--                            required autocomplete="current-password" />--}}

{{--            <x-input-error :messages="$errors->get('password')" class="mt-2" />--}}
{{--        </div>--}}

{{--        <!-- Remember Me -->--}}
{{--        <div class="block mt-4">--}}
{{--            <label for="remember_me" class="inline-flex items-center">--}}
{{--                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">--}}
{{--                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>--}}
{{--            </label>--}}
{{--        </div>--}}

{{--        <div class="flex items-center justify-end mt-4">--}}
{{--            @if (Route::has('password.request'))--}}
{{--                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">--}}
{{--                    {{ __('Forgot your password?') }}--}}
{{--                </a>--}}
{{--            @endif--}}

{{--            <x-primary-button class="ms-3">--}}
{{--                {{ __('Log in') }}--}}
{{--            </x-primary-button>--}}
{{--        </div>--}}

{{--        <div class="block mt-4">--}}
{{--            @if (Route::has('register'))--}}
{{--                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('register') }}">--}}
{{--                    Don't have an account? {{ __('Register') }}--}}
{{--                </a>--}}
{{--            @endif--}}
{{--        </div>--}}
{{--    </form>--}}
{{--</x-guest-layout>--}}
@extends('Auth_.index')

<head>
    <script src="{{ asset('./login.js') }}"></script>
</head>

@section('content')
    <div class="center_1">
        <div class="card_re" style="height:470px !important;">
            <div class="d-flex justify-content-center" style="align-items: center;">
                <img src="./img/img.png" class="mr-3" alt="" style="width: 68px; height: 59px;">
                <div class="text-center">
                    <p class="m-0 p_top">TRUNG TÂM QUẢN LÝ KÝ TÚC XÁ</p>
                    <p class="m-0 p_bottom">WEBSITE ĐĂNG NHẬP</p>
                </div>
            </div>
            <hr>
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="col-md-12" style="margin-top:30px; display: flex; justify-content: center;">
                    <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" placeholder="Email" required autofocus autocomplete="username" style="width: 90%;" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="col-md-12 margin-input position-relative">
                    <x-text-input id="password" class="form-control password-field" type="password" name="password" placeholder="Password" required autocomplete="current-password" style="width: 90% !important;" />
                    <button class="check position-absolute toggle-password" style="width:10% !important;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
                            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
                        </svg>
                    </button>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
            {{--Remember me & Change password--}}
                <div class="d-flex justify-content-between align-items-center mt-4" style="width: 82%; margin: 0 auto;">
                    <div class="remember-me">
                        <label for="remember_me" class="inline-flex items-center p_dont">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                            <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                        </label>
                    </div>
                    <div class="change-password">
                        <a href="{{ route('password.request') }}" class="change"><u>Change Password</u></a>
                    </div>
                </div>

                <div class="col-md-12 margin-input text-center d-flex justify-content-center">
                    <x-primary-button class="btn_re" type="submit">
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>

                <div class="mt-4 text-center col-md-12">
                    <p class="m-0 p_dont">Don't have an account? </p>
                    <a href="{{ route('register') }}" class="p_register"><u>Register</u></a>
                </div>
            </form>
        </div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle Register link click event
        const registerLink = document.querySelector('.p_register');
        if (registerLink) {
            registerLink.addEventListener('click', function(event) {
                event.preventDefault();  // Prevent the default link action
                window.location.href = "{{ route('register') }}";  // Redirect to register page
            });
        }

        // Xử lý link Thay đổi mật khẩu
        const forgotPasswordLink = document.querySelector('.change');
        if (forgotPasswordLink) {
            forgotPasswordLink.addEventListener('click', function(event) {
                event.preventDefault();  // Prevent the default link action
                window.location.href = "{{ route('password.request') }}";  // Redirect to password reset page
            });
        }
    });
</script>
