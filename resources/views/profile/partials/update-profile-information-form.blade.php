<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="photo" :value="__('プロフィール写真')" />
            @if($user->photo)
                <div class="mt-2 mb-2">
                    <img src="{{ asset('storage/' . $user->photo) }}" alt="プロフィール写真" class="w-24 h-24 rounded-full object-cover border border-gray-200">
                </div>
            @endif
            <input id="photo" name="photo" type="file" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" accept="image/jpeg,image/png,image/jpg,image/gif" />
            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">JPEG, PNG, JPG, GIF（最大5MB）</p>
            <x-input-error class="mt-2" :messages="$errors->get('photo')" />
        </div>

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
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div>
            <x-input-label :value="__('役職についている')" />
            <div class="mt-2 flex gap-6">
                <label class="inline-flex items-center">
                    <input type="radio" name="has_position" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" {{ old('has_position', $user->has_position) ? 'checked' : '' }}>
                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">はい</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="has_position" value="0" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" {{ old('has_position', $user->has_position) ? '' : 'checked' }}>
                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">いいえ</span>
                </label>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('has_position')" />
        </div>

        <div>
            <x-input-label for="phone" :value="__('電話番号')" />
            <x-text-input id="phone" name="phone" type="tel" class="mt-1 block w-full" :value="old('phone', $user->phone)" autocomplete="tel" placeholder="090-1234-5678" />
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        <div>
            <x-input-label for="gender" :value="__('性別')" />
            <select id="gender" name="gender" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">{{ __('選択してください') }}</option>
                <option value="male" {{ old('gender', $user->gender) === 'male' ? 'selected' : '' }}>{{ __('男性') }}</option>
                <option value="female" {{ old('gender', $user->gender) === 'female' ? 'selected' : '' }}>{{ __('女性') }}</option>
                <option value="other" {{ old('gender', $user->gender) === 'other' ? 'selected' : '' }}>{{ __('その他') }}</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('gender')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
