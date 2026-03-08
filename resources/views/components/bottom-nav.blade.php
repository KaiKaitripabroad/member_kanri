<div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-100 py-3 px-10 flex justify-between items-center">
        <a href="{{ route('dashboard') }}" class="block text-center no-underline min-w-[4rem]">
            <div class="text-xl text-blue-600">🏠</div>
            <div class="text-[10px] text-blue-600 font-bold">ホーム</div>
        </a>
        <div class="text-center min-w-[4rem]">
            <div class="text-xl text-gray-300">👥</div>
            <div class="text-[10px] text-gray-400">メンバー</div>
        </div>
        <a href="{{ route('events.index') }}" class="block text-center no-underline min-w-[4.5rem]">
            <div class="text-3xl mb-1 {{ request()->routeIs('events.*') ? '' : 'grayscale opacity-60' }}">📅</div>
            <div class="text-[11px] {{ request()->routeIs('events.*') ? 'text-blue-600 font-bold' : 'text-gray-500' }}">イベント</div>
        </a>
        <a href="{{ route('profile.edit') }}" class="block text-center no-underline min-w-[4rem]">
            <div class="text-xl text-gray-300">⚙️</div>
            <div class="text-[10px] text-gray-400">設定</div>
        </a>
    </div>