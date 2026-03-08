<section class="max-w-2xl mx-auto pb-12">
    <header class="mb-8 px-4">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>
        <p class="mt-1 text-sm text-gray-500">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('patch')

        <div class="flex flex-col items-center py-6">
            <div class="relative group">
                @if($user->photo)
                    <img src="{{ asset('storage/' . $user->photo) }}" alt="プロフィール写真" class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-md">
                @else
                    <div class="w-24 h-24 rounded-full bg-indigo-500 flex items-center justify-center text-white text-3xl font-bold shadow-md">
                        {{ mb_substr($user->name, 0, 1) }}
                    </div>
                @endif
                <label for="photo" class="absolute bottom-0 right-0 bg-white p-2 rounded-full shadow-lg border border-gray-100 cursor-pointer hover:bg-gray-50 transition active:scale-90">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                    </svg>
                    <input id="photo" name="photo" type="file" class="hidden" accept="image/*" />
                </label>
            </div>
            <p class="mt-3 text-xs text-gray-400">JPEG, PNG, JPG, GIF（最大5MB）</p>
            <x-input-error class="mt-2" :messages="$errors->get('photo')" />
        </div>

        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-3xl border border-gray-100 dark:border-gray-700 overflow-hidden text-lg">
            <div class="divide-y divide-gray-50 dark:divide-gray-700">
                
                <div class="px-6 py-5 flex items-center">
                    <x-input-label for="name" :value="__('氏名')" class="w-1/3 text-gray-400 font-medium" />
                    <div class="w-2/3">
                        <x-text-input id="name" name="name" type="text" class="w-full border-none bg-transparent p-0 focus:ring-0 text-gray-900 font-bold" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                        <x-input-error class="mt-1" :messages="$errors->get('name')" />
                    </div>
                </div>

                <div class="px-6 py-5 flex items-center">
                    <x-input-label for="student_id" :value="__('学籍番号')" class="w-1/3 text-gray-400 font-medium" />
                    <div class="w-2/3">
                        <x-text-input id="student_id" name="student_id" type="text" class="w-full border-none bg-transparent p-0 focus:ring-0 text-gray-900 font-bold" :value="old('student_id', $user->student_id)" placeholder="例: 2026A123" />
                        <x-input-error class="mt-1" :messages="$errors->get('student_id')" />
                    </div>
                </div>

                <div class="px-6 py-5 flex items-center">
                    <x-input-label for="email" :value="__('メール')" class="w-1/3 text-gray-400 font-medium" />
                    <div class="w-2/3">
                        <x-text-input id="email" name="email" type="email" class="w-full border-none bg-transparent p-0 focus:ring-0 text-gray-900 font-bold" :value="old('email', $user->email)" required autocomplete="username" />
                        <x-input-error class="mt-1" :messages="$errors->get('email')" />
                        
                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                            <div class="mt-1">
                                <button form="send-verification" class="text-xs text-blue-600 hover:underline">
                                    {{ __('Click here to re-send the verification email.') }}
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-3xl border border-gray-100 dark:border-gray-700 overflow-hidden text-lg">
            <div class="divide-y divide-gray-50 dark:divide-gray-700">
                
                <div class="px-6 py-5 flex items-center">
                    <x-input-label for="position" :value="__('役職')" class="w-1/3 text-gray-400 font-medium" />
                        <div class="w-2/3">
                            <x-text-input id="position" name="position" type="text" class="w-full border-none bg-transparent p-0 focus:ring-0 text-gray-900 font-bold" :value="old('position', $user->position)" placeholder="例: 部長、会計など" />
                            <x-input-error class="mt-1" :messages="$errors->get('position')" />
                        </div>
                </div>

                <div class="px-6 py-5 flex items-center">
                    <x-input-label for="phone" :value="__('電話番号')" class="w-1/3 text-gray-400 font-medium" />
                    <div class="w-2/3">
                        <x-text-input id="phone" name="phone" type="tel" class="w-full border-none bg-transparent p-0 focus:ring-0 text-gray-900 font-bold" :value="old('phone', $user->phone)" placeholder="090-1234-5678" />
                        <x-input-error class="mt-1" :messages="$errors->get('phone')" />
                    </div>
                </div>

                <div class="px-6 py-5 flex items-center">
                    <x-input-label for="gender" :value="__('性別')" class="w-1/3 text-gray-400 font-medium" />
                    <div class="w-2/3">
                        <select id="gender" name="gender" class="w-full border-none bg-transparent p-0 focus:ring-0 text-gray-900 font-bold cursor-pointer appearance-none">
                            <option value="">{{ __('選択してください') }}</option>
                            <option value="male" {{ old('gender', $user->gender) === 'male' ? 'selected' : '' }}>{{ __('男性') }}</option>
                            <option value="female" {{ old('gender', $user->gender) === 'female' ? 'selected' : '' }}>{{ __('女性') }}</option>
                            <option value="other" {{ old('gender', $user->gender) === 'other' ? 'selected' : '' }}>{{ __('その他') }}</option>
                        </select>
                        <x-input-error class="mt-1" :messages="$errors->get('gender')" />
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col items-center pt-6 gap-4">
            <x-primary-button class="px-16 py-4 bg-blue-600 hover:bg-blue-700 active:scale-95 transition rounded-full text-lg shadow-xl shadow-blue-100 border-none">
                {{ __('SAVE') }}
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-green-600 font-bold">
                    {{ __('プロフィールを更新しました') }}
                </p>
            @endif
        </div>
    </form>
</section>
