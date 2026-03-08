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
                    <img src="{{ asset('storage/' . $user->photo) }}" alt="プロフィール写真" class="w-24 h-24 rounded-full object-contain border border-gray-200">
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
            <x-input-label for="role" :value="__('役職（任意）')" />
            <select id="role" name="role" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">なし</option>
                <option value="代表（部長）" {{ old('role', $user->role) === '代表（部長）' ? 'selected' : '' }}>代表（部長）</option>
                <option value="副代表（副部長）" {{ old('role', $user->role) === '副代表（副部長）' ? 'selected' : '' }}>副代表（副部長）</option>
                <option value="会計" {{ old('role', $user->role) === '会計' ? 'selected' : '' }}>会計</option>
                <option value="書紀" {{ old('role', $user->role) === '書紀' ? 'selected' : '' }}>書紀</option>
                <option value="広報" {{ old('role', $user->role) === '広報' ? 'selected' : '' }}>広報</option>
                <option value="外務" {{ old('role', $user->role) === '外務' ? 'selected' : '' }}>外務</option>
                <option value="企画" {{ old('role', $user->role) === '企画' ? 'selected' : '' }}>企画</option>
            </select>
            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">役職がある場合のみイベントを投稿できます</p>
            <x-input-error class="mt-2" :messages="$errors->get('role')" />
        </div>

        <div>
            <x-input-label for="student_number" :value="__('学籍番号')" />
            <x-text-input id="student_number" name="student_number" type="text" class="mt-1 block w-full" :value="old('student_number', $user->student_number)" placeholder="例: 202412345" />
            <x-input-error class="mt-2" :messages="$errors->get('student_number')" />
        </div>

        <div>
            <x-input-label for="department" :value="__('学部・学科')" />
            <x-text-input id="department" name="department" type="text" class="mt-1 block w-full" :value="old('department', $user->department)" placeholder="例: 情報学部 情報学科" />
            <x-input-error class="mt-2" :messages="$errors->get('department')" />
        </div>

        <div>
            <x-input-label for="grade" :value="__('学年')" />
            <select id="grade" name="grade" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">選択してください</option>
                @for($i = 1; $i <= 6; $i++)
                    <option value="{{ $i }}" {{ old('grade', $user->grade) == $i ? 'selected' : '' }}>{{ $i }}年</option>
                @endfor
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('grade')" />
        </div>

        <div>
            <x-input-label for="profile_location" :value="__('場所・住所（地図用）')" />
            <input type="text" id="profile_location" name="location_name" value="{{ old('location_name', $user->location_name) }}"
                   class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                   placeholder="住所や施設名を入力して候補から選択">
            <input type="hidden" name="latitude" id="profile_latitude" value="{{ old('latitude', $user->latitude) }}">
            <input type="hidden" name="longitude" id="profile_longitude" value="{{ old('longitude', $user->longitude) }}">
            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">選択すると緯度・経度が保存され、メンバー詳細で地図表示されます</p>
            <x-input-error class="mt-2" :messages="$errors->get('latitude')" />
            <x-input-error class="mt-2" :messages="$errors->get('longitude')" />
        </div>

        <div>
            <x-input-label for="joined_at" :value="__('加入日')" />
            <x-text-input id="joined_at" name="joined_at" type="date" class="mt-1 block w-full" :value="old('joined_at', $user->joined_at?->format('Y-m-d'))" />
            <x-input-error class="mt-2" :messages="$errors->get('joined_at')" />
        </div>

        <div>
            <x-input-label for="notes" :value="__('備考')" />
            <textarea id="notes" name="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="自由記述">{{ old('notes', $user->notes) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('notes')" />
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

    @if(config('services.google.maps_api_key'))
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}&libraries=places&callback=initProfilePlace" async defer></script>
    <script>
        function initProfilePlace() {
            if (typeof google === 'undefined' || !document.getElementById('profile_location')) return;
            var input = document.getElementById('profile_location');
            var latInput = document.getElementById('profile_latitude');
            var lngInput = document.getElementById('profile_longitude');
            var autocomplete = new google.maps.places.Autocomplete(input, { types: ['establishment', 'geocode'], componentRestrictions: { country: 'jp' } });
            autocomplete.addListener('place_changed', function() {
                var place = autocomplete.getPlace();
                if (place.geometry) {
                    latInput.value = place.geometry.location.lat();
                    lngInput.value = place.geometry.location.lng();
                }
            });
            input.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' && document.querySelector('.pac-container') && document.querySelector('.pac-container').offsetParent !== null) e.preventDefault();
            });
        }
    </script>
    @endif
</section>
