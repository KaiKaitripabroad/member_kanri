<x-app-layout>
    <div class="py-8 px-6 pb-24">
        <div class="mb-8">
            <p class="text-gray-500 text-lg">ようこそ、</p>
            <h1 class="text-3xl font-bold text-gray-900">{{ Auth::user()->name }} さん</h1>
        </div>

        <div class="grid grid-cols-3 gap-3 mb-10">
            <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm text-center">
                <div class="text-3xl font-bold text-blue-600">{{ $totalMembers }}</div>
                <div class="text-[10px] text-gray-400 mt-1">総メンバー数</div>
            </div>
            <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm text-center">
                <div class="text-3xl font-bold text-emerald-500">{{ $newJoins }}</div>
                <div class="text-[10px] text-gray-400 mt-1">今月の加入</div>
            </div>
            <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm text-center">
                <div class="text-3xl font-bold text-orange-400">{{ $unconfirmed }}</div>
                <div class="text-[10px] text-gray-400 mt-1">未確認</div>
            </div>
        </div>

        <div class="mb-6">
            <h3 class="text-gray-400 font-bold mb-4">最近の更新</h3>
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
                @foreach($recentUpdates as $user)
                @php
                $isNewThisMonth = $user->created_at->isCurrentMonth();
                @endphp
                <div class="flex items-center p-5 border-b border-gray-50 last:border-0">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center text-white font-bold mr-4 bg-indigo-500">
                        {{ mb_substr($user->name, 0, 1) }}
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="font-bold text-gray-900 text-lg">{{ $user->name }}</h4>
                                <p class="text-gray-400 text-sm">{{ $user->email }} — {{ $isNewThisMonth ? '新規登録' : '会員' }}</p>
                            </div>
                            <span class="px-3 py-1 rounded-full text-xs {{ $isNewThisMonth ? 'bg-emerald-50 text-emerald-500' : 'bg-blue-50 text-blue-500' }}">
                                {{ $isNewThisMonth ? '新規' : '会員' }}
                            </span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <button class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-xl shadow-lg shadow-blue-200 flex items-center justify-center transition-all">
            <span class="mr-2">👥</span> メンバー一覧を見る
        </button>
    </div>

    @include('components.bottom-nav')
</x-app-layout>