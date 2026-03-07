<x-app-layout>
    <div class="py-12 pb-24">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if($user->photo)
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex flex-col items-center">
                    <img src="{{ asset('storage/' . $user->photo) }}" alt="{{ $user->name }}のプロフィール写真" class="w-32 h-32 rounded-full object-cover border-4 border-gray-200 dark:border-gray-600 shadow-md">
                    <p class="mt-4 text-lg font-medium text-gray-900 dark:text-gray-100">{{ $user->name }}</p>
                </div>
            @endif
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>

    <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-100 py-3 px-10 flex justify-between items-center">
        <a href="{{ route('dashboard') }}" class="block text-center no-underline min-w-[4rem]">
            <div class="text-xl text-gray-300">🏠</div>
            <div class="text-[10px] text-gray-400">ホーム</div>
        </a>
        <div class="text-center min-w-[4rem]">
            <div class="text-xl text-gray-300">👥</div>
            <div class="text-[10px] text-gray-400">メンバー</div>
        </div>
        <a href="{{ route('profile.edit') }}" class="block text-center no-underline min-w-[4rem]">
            <div class="text-xl text-blue-600">⚙️</div>
            <div class="text-[10px] text-blue-600 font-bold">設定</div>
        </a>
    </div>
</x-app-layout>
