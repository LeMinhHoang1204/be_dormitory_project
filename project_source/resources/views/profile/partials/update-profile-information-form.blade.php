<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's user_profile.php information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        @if($user->role === 'student' && isset($user->student))
            <div>
                <x-input-label for="university" :value="__('University')" />
                <x-text-input id="uni_name" name="uni_name" type="text" class="mt-1 block w-full" :value="old('uni_name', $user->student->uni_name)" required autofocus autocomplete="uni_name" />
                <x-input-error class="mt-2" :messages="$errors->get('university')" />
            </div>

            <div>
                <x-input-label for="Student ID" :value="__('Student ID')" />
                <x-text-input id="uni_id" name="uni_id" type="text" class="mt-1 block w-full" :value="old('uni_id', $user->student->uni_id)" required autofocus autocomplete="uni_id" />
                <x-input-error class="mt-2" :messages="$errors->get('uni_id')" />
            </div>

            <div>
                <x-input-label for="Phone number" :value="__('Phone number')" />
                <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $user->phone)" required autofocus autocomplete="phone" />
                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
            </div>

            <div>
                <x-input-label for="Date of Birth" :value="__('Date of Birth')" />
                <x-text-input id="dob" name="dob" type="date" class="mt-1 block w-full" :value="old('dob', $user->student->dob->format('Y-m-d'))" required autofocus autocomplete="dob" />

                <x-input-error class="mt-2" :messages="$errors->get('dob')" />
            </div>

            <div>
                <x-input-label for="Gender" :value="__('Gender')" />
                <x-text-input id="gender" name="gender" type="text" class="mt-1 block w-full" :value="old('gender', $user->student->gender === 'male' ? 'Male' : ($user->student->gender === 'female' ? 'Female' : ''))" required autofocus autocomplete="gender" />
                <x-input-error class="mt-2" :messages="$errors->get('gender')" />
            </div>
        @endif

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'user_profile.php-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
