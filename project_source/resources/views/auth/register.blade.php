<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- University -->
        <div>
            <x-input-label for="university" :value="__('Chọn trường đại học')" />
            <select id="university" name="university" class="block mt-1 w-full" required>
                <option value="">-- Chọn trường --</option>
                <option value="DHQGHN">Đại học Quốc gia Hà Nội</option>
                <option value="DHQGTPHCM">Đại học Quốc gia TP.HCM</option>
                <option value="BKHN">Đại học Bách khoa Hà Nội</option>
                <option value="BKHCM">Đại học Bách khoa TP.HCM</option>
                <option value="KTQD">Đại học Kinh tế Quốc dân</option>
                <option value="FTU">Đại học Ngoại thương</option>
                <option value="UEH">Đại học Kinh tế TP.HCM</option>
                <option value="YHN">Đại học Y Hà Nội</option>
                <option value="YTPHCM">Đại học Y Dược TP.HCM</option>
                <!-- Thêm các trường đại học khác tùy nhu cầu -->
            </select>
            <x-input-error :messages="$errors->get('university')" class="mt-2" />
        </div>

        <!-- Student ID -->
        <div>
            <x-input-label for="stu_uni_id" :value="__('Student ID')" />
            <x-text-input id="stu_uni_id" class="block mt-1 w-full" type="text" name="stu_uni_id" :value="old('stu_uni_id')" required autofocus autocomplete="stu_uni_id" />
            <x-input-error :messages="$errors->get('stu_uni_id')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Phone Number -->
        <div class="mt-4">
            <x-input-label for="phone" :value="__('Phone Number')" />
            <x-text-input id="phone" class="block mt-1 w-full" type="phone" name="phone" :value="old('phone')" required autocomplete="phone" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- Date Of Birth -->
        <div class="mt-4">
            <x-input-label for="dob" :value="__('Phone Number')" />
            <x-text-input id="dob" class="block mt-1 w-full" type="date" name="dob" :value="old('dob')" required autocomplete="dob" />
            <x-input-error :messages="$errors->get('dob')" class="mt-2" />
        </div>

        <!-- Gender -->
        <div class="mt-4">
            <x-input-label for="gender" :value="__('Gender')" />

            <div class="mt-2">
                <!-- Radio for Male -->
                <label for="male" class="inline-flex items-center">
                    <input id="male" type="radio" name="gender" value="1" class="form-radio" {{ old('gender') == 1 ? 'checked' : '' }} required>
                    <span class="ml-2">{{ __('Male') }}</span>
                </label>

                <!-- Radio for Female -->
                <label for="female" class="inline-flex items-center ml-6">
                    <input id="female" type="radio" name="gender" value="0" class="form-radio" {{ old('gender') == 0 ? 'checked' : '' }} required>
                    <span class="ml-2">{{ __('Female') }}</span>
                </label>
            </div>

            <x-input-error :messages="$errors->get('gender')" class="mt-2" />
        </div>


        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
