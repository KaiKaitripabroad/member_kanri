<x-app-layout>
    <div class="py-12 pb-24">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- 1. プロフィール画像セクション（すでに中央寄せ済み） --}}
            @if($user->photo)
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex flex-col items-center">
                    <img src="{{ asset('storage/' . $user->photo) }}" alt="{{ $user->name }}のプロフィール写真" class="w-32 h-32 rounded-full object-cover border-4 border-gray-200 dark:border-gray-600 shadow-md">
                    <p class="mt-4 text-lg font-medium text-gray-900 dark:text-gray-100">{{ $user->name }}</p>
                </div>
            @endif

            {{-- 2. プロフィール情報編集フォーム --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                {{-- max-w-xl を mx-auto に変更して中央寄せを実現 --}}
                <div class="mx-auto">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- 3. パスワード更新フォーム --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                {{-- mx-auto で中央寄せ --}}
                <div class="mx-auto">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- 4. アカウント削除フォーム --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                {{-- mx-auto で中央寄せ --}}
                <div class="mx-auto">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>

    @include('components.bottom-nav')
</x-app-layout>
