{{--<x-guest-layout>--}}
{{--    <form method="POST" action="{{ route('register') }}">--}}
{{--        @csrf--}}

{{--        <!-- Email Address -->--}}
{{--        <div class="mt-4">--}}
{{--            <x-input-label for="email" :value="__('Email')" />--}}
{{--            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />--}}
{{--            <x-input-error :messages="$errors->get('email')" class="mt-2" />--}}
{{--        </div>--}}

{{--        <!-- Name -->--}}
{{--        <div class="mt-4">--}}
{{--            <x-input-label for="name" :value="__('Fullname')" />--}}
{{--            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />--}}
{{--            <x-input-error :messages="$errors->get('name')" class="mt-2" />--}}
{{--        </div>--}}

{{--        <!-- University -->--}}
{{--        <div class="mt-4">--}}
{{--            <x-input-label for="university" :value="__('Chọn trường đại học')" />--}}
{{--            <select id="university" name="university" class="block mt-1 w-full" required>--}}
{{--                <option value="">-- Chọn trường --</option>--}}
{{--                <option value="DHQGHN">Đại học Quốc gia Hà Nội</option>--}}
{{--                <option value="DHQGTPHCM">Đại học Quốc gia TP.HCM</option>--}}
{{--                <option value="BKHN">Đại học Bách khoa Hà Nội</option>--}}
{{--                <option value="BKHCM">Đại học Bách khoa TP.HCM</option>--}}
{{--                <option value="KTQD">Đại học Kinh tế Quốc dân</option>--}}
{{--                <option value="FTU">Đại học Ngoại thương</option>--}}
{{--                <option value="UEH">Đại học Kinh tế TP.HCM</option>--}}
{{--                <option value="YHN">Đại học Y Hà Nội</option>--}}
{{--                <option value="YTPHCM">Đại học Y Dược TP.HCM</option>--}}
{{--                <!-- Thêm các trường đại học khác tùy nhu cầu -->--}}
{{--            </select>--}}
{{--            <x-input-error :messages="$errors->get('university')" class="mt-2" />--}}
{{--        </div>--}}

{{--        <!-- Student ID -->--}}
{{--        <div class="mt-4">--}}
{{--            <x-input-label for="stu_uni_id" :value="__('Student ID')" />--}}
{{--            <x-text-input id="stu_uni_id" class="block mt-1 w-full" type="text" name="stu_uni_id" :value="old('stu_uni_id')" required autofocus autocomplete="stu_uni_id" />--}}
{{--            <x-input-error :messages="$errors->get('stu_uni_id')" class="mt-2" />--}}
{{--        </div>--}}

{{--        <!-- Phone Number -->--}}
{{--        <div class="mt-4">--}}
{{--            <x-input-label for="phone" :value="__('Phone Number')" />--}}
{{--            <x-text-input id="phone" class="block mt-1 w-full" type="phone" name="phone" :value="old('phone')" required autocomplete="phone" />--}}
{{--            <x-input-error :messages="$errors->get('phone')" class="mt-2" />--}}
{{--        </div>--}}

{{--        <!-- Date Of Birth -->--}}
{{--        <div class="mt-4">--}}
{{--            <x-input-label for="dob" :value="__('Date Of Birth')" />--}}
{{--            <x-text-input id="dob" class="block mt-1 w-full" type="date" name="dob" :value="old('dob')" required autocomplete="dob" />--}}
{{--            <x-input-error :messages="$errors->get('dob')" class="mt-2" />--}}
{{--        </div>--}}

{{--        <!-- Gender -->--}}
{{--        <div class="mt-4">--}}
{{--            <x-input-label for="gender" :value="__('Gender')" />--}}

{{--            <div class="mt-2">--}}
{{--                <!-- Radio for Male -->--}}
{{--                <label for="male" class="inline-flex items-center">--}}
{{--                    <input id="male" type="radio" name="gender" value="1" class="form-radio" {{ old('gender') == 1 ? 'checked' : '' }} required>--}}
{{--                    <span class="ml-2">{{ __('Male') }}</span>--}}
{{--                </label>--}}

{{--                <!-- Radio for Female -->--}}
{{--                <label for="female" class="inline-flex items-center ml-6">--}}
{{--                    <input id="female" type="radio" name="gender" value="0" class="form-radio" {{ old('gender') == 0 ? 'checked' : '' }} required>--}}
{{--                    <span class="ml-2">{{ __('Female') }}</span>--}}
{{--                </label>--}}
{{--            </div>--}}

{{--            <x-input-error :messages="$errors->get('gender')" class="mt-2" />--}}
{{--        </div>--}}


{{--        <!-- Password -->--}}
{{--        <div class="mt-4">--}}
{{--            <x-input-label for="password" :value="__('Password')" />--}}

{{--            <x-text-input id="password" class="block mt-1 w-full"--}}
{{--                            type="password"--}}
{{--                            name="password"--}}
{{--                            required autocomplete="new-password" />--}}

{{--            <x-input-error :messages="$errors->get('password')" class="mt-2" />--}}
{{--        </div>--}}

{{--        <!-- Confirm Password -->--}}
{{--        <div class="mt-4">--}}
{{--            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />--}}

{{--            <x-text-input id="password_confirmation" class="block mt-1 w-full"--}}
{{--                            type="password"--}}
{{--                            name="password_confirmation" required autocomplete="new-password" />--}}

{{--            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />--}}
{{--        </div>--}}

{{--        <div class="flex items-center justify-end mt-4">--}}
{{--            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">--}}
{{--                {{ __('Already registered?') }}--}}
{{--            </a>--}}

{{--            <x-primary-button class="ms-4">--}}
{{--                {{ __('Register') }}--}}
{{--            </x-primary-button>--}}
{{--        </div>--}}
{{--    </form>--}}
{{--</x-guest-layout>--}}


{{--TODO: CHỈNH LẠI ĐỊNH DẠNG THÔNG BÁO LỖI (HIỂN THỊ XẤU), CHỈNH ICON MẮT PASSWORD--}}
@extends('Auth_.index')

@section('content')
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
    <div class="center">

        <div class="card_re" style="
             width: 100%;
        max-width: 500px;
        padding: 20px;
        background: #fff;
        border-radius: 8px;
                     height: 100%;

        ">
            <div class="d-flex justify-content-center " style="align-items: center;">
                <img src="{{ asset('./img/img.png') }}" class="mr-3" alt="" style="width: 68px; height: 59px;">
                <div class="text-center">
                    <p class="m-0 p_top">TRUNG TÂM QUẢN LÝ KÝ TÚC XÁ</p>
                    <p class="m-0 p_bottom">WEBSITE ĐĂNG KÝ</p>
                </div>
            </div>
            <hr>
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="row">

                    <!-- Email -->
                    <div class="col-md-12 margin-input">
                        <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" placeholder="Email" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Fullname -->
                    <div class="col-md-12 margin-input" style="margin-top:30px; display: flex; justify-content: center;">
                        <x-text-input id="name" class="form-control" type="text" name="name" :value="old('name')" placeholder="Fullname" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- University -->
                    <div class="col-md-12 margin-input">
                        <select class="form-control" name="university" required style="width: 90%;">
                            <option value="" disabled selected>Choose University</option>
                            <option value="DHQGHN">Đại học Quốc gia Hà Nội</option>
                            <option value="DHQGTPHCM">Đại học Quốc gia TP.HCM</option>
                            <option value="BKHN">Đại học Bách khoa Hà Nội</option>
                            <option value="BKHCM">Đại học Bách khoa TP.HCM</option>
                            <option value="KTQD">Đại học Kinh tế Quốc dân</option>
                            <option value="FTU">Đại học Ngoại thương</option>
                            <option value="UEH">Đại học Kinh tế TP.HCM</option>
                            <option value="YHN">Đại học Y Hà Nội</option>
                            <option value="YTPHCM">Đại học Y Dược TP.HCM</option>
                        </select>
                        <x-input-error :messages="$errors->get('university')" class="mt-2" />
                    </div>

                    <!-- Student ID -->
                    <div class="col-md-12 margin-input">
                        <x-text-input id="stu_uni_id" class="form-control" type="text" name="stu_uni_id" :value="old('stu_uni_id')" placeholder="Student ID" required />
                        <x-input-error :messages="$errors->get('stu_uni_id')" class="mt-2" />
                    </div>
                    {{--        <!-- Student ID -->--}}
                    {{--        <div class="mt-4">--}}
                    {{--            <x-input-label for="stu_uni_id" :value="__('Student ID')" />--}}
                    {{--            <x-text-input id="stu_uni_id" class="block mt-1 w-full" type="text" name="stu_uni_id" :value="old('stu_uni_id')" required autofocus autocomplete="stu_uni_id" />--}}
                    {{--            <x-input-error :messages="$errors->get('stu_uni_id')" class="mt-2" />--}}
                    {{--        </div>--}}

                    <!-- Phone Number -->
                    <div class="col-md-12 margin-input">
                        <x-text-input id="phone" class="form-control" type="text" name="phone" :value="old('phone')" placeholder="Phone number" required />
                        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                    </div>


                    <!-- Date Of Birth -->
                    <div class="col-md-12 margin-input" style="margin-bottom: 0; height: 5px">
                        <div style="text-align: left; margin-left: 0;  font-size: 16px;">
                            Date of Birth:
                        </div>
                    </div>
                    <div class="col-md-12 margin-input">
                        <!-- Trường nhập liệu (form-control) -->
                        <x-text-input id="dob" class="form-control" type="date" name="dob" :value="old('dob')" required />
                        <x-input-error :messages="$errors->get('dob')" class="mt-2" />
                    </div>




                    <!-- Gender -->
                    <div class="col-md-12 margin-input">
                        <select class="form-control" name="gender" required style="width: 90%;">
                            <option value="" disabled selected>Choose Gender</option>
                            <option value="1" {{ old('gender') == '1' ? 'selected' : '' }}>Male</option>
                            <option value="0" {{ old('gender') == '0' ? 'selected' : '' }}>Female</option>
                        </select>
                        <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="col-md-12 margin-input position-relative">
                        <x-text-input id="password" class="form-control password-field" type="password" name="password" placeholder="Password" required autocomplete="new-password" />
                        <button type="button" class="check position-absolute toggle-password" style="width: 10% !important;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
                                <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
                            </svg>
                        </button>
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600 space-y-1" />

                    </div>

                    <!-- Confirm Password -->
                    <div class="col-md-12 margin-input position-relative">
                        <x-text-input id="password_confirmation" class="form-control password-field" type="password" name="password_confirmation" placeholder="Confirm Password" required autocomplete="new-password" />
                        <button type="button" class="check position-absolute toggle-password" style="width: 10% !important;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
                                <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
                            </svg>
                        </button>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-sm text-red-600 space-y-1" />

                    </div>

                    <!-- Already Registered Link and Submit Button -->
                    <div class="col-md-12 margin-input text-center d-flex justify-content-center flex-column align-items-center mt-4">
                        <a href="{{ route('login') }}" class="underline text-sm text-gray-600 hover:text-gray-900 mb-3">
                            {{ __('Already registered?') }}
                        </a>
                        <x-primary-button class="btn_re">
                            Register
                        </x-primary-button>
                    </div>


                </div>
            </form>
        </div>
    </div>

@endsection
