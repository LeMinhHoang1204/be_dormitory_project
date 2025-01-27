
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
    <title>Login Dormitory</title>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePasswordButtons = document.querySelectorAll('.toggle-password');

            togglePasswordButtons.forEach(button => {
                const passwordField = button.closest('.position-relative').querySelector('.password-field');

                button.addEventListener('click', function(event) {
                    event.preventDefault();

                    const isPasswordVisible = passwordField.type === 'text';
                    passwordField.type = isPasswordVisible ? 'password' : 'text';

                    button.innerHTML = isPasswordVisible ? `
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                    <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
                    <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
                </svg>
            ` : `
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-slash" viewBox="0 0 16 16">
                    <path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7 7 0 0 0-2.79.588l.77.771A6 6 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755q-.247.248-.517.486z"/>
                    <path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829"/>
                    <path d="M3.35 5.47q-.27.24-.518.487A13 13 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7 7 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12z"/>
                </svg>
            `;
                });
            });
        });

    </script>
    <style>
        .text-sm {
            font-size: 14px;
        }

        .text-red-600 {
            color: #ff4d4f;
        }

        .space-y-1 > * + * {
            margin-top: 4px;
        }

    </style>
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
                    <div class="position-relative" style="width: 90%;">
                        <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" placeholder="Email" required autofocus autocomplete="username" />
                        <!-- Display the error message above the input field -->
                        <x-input-error :messages="$errors->get('email')" class="mt-2 position-absolute" style="top: -32px; left: -38px; font-size: 14px;" />
                    </div>
                </div>

                <div class="col-md-12" style="margin-top:20px; display: flex; justify-content: center;">
                    <div class="position-relative" style="width: 90%;">
                        <x-text-input id="password" class="form-control password-field" type="password" name="password" placeholder="Password" required autocomplete="current-password" />
                        <button class="check position-absolute toggle-password" style="width:10% !important; margin-right: -20px!important; margin-top: 5px">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
                                <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
                            </svg>
                        </button>
                        <x-input-error :messages="$errors->get('password')" class="mt-2 position-absolute" style="top: -32px; left: -40px; font-size: 14px;" />
                    </div>
                </div>

{{--            Remember me & Change password--}}
                <div class="d-flex justify-content-between align-items-center mt-4" style="width: 82%; margin: 0 auto;">
                    <div class="remember-me">
                        <label for="remember_me" class="inline-flex items-center p_dont">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                            <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                        </label>
                    </div>
                    <div class="change-password">
                        <a href="{{ route('password.request') }}" class="change"><u>Forget Password</u></a>
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
