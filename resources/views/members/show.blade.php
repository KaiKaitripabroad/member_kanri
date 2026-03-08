<x-app-layout>
    <div class="bg-gray-50 min-h-screen pb-24">
        <header class="bg-white px-6 py-4 flex items-center border-b border-gray-100 sticky top-0 z-10">
            <a href="{{ route('members.index') }}" class="text-blue-600 mr-4">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <h1 class="text-xl font-bold text-gray-800">メンバー詳細</h1>
        </header>

        <div class="px-6 py-8">
            <div class="text-center mb-10">
                <div class="relative inline-block">
                    @if($user->photo)
                        <img src="{{ asset('storage/' . $user->photo) }}" class="w-28 h-28 rounded-full object-contain border-4 border-white shadow-sm mx-auto" alt="">
                    @else
                        <div class="w-28 h-28 rounded-full bg-indigo-500 flex items-center justify-center text-white text-4xl font-bold mx-auto shadow-sm">
                            {{ mb_substr($user->name, 0, 1) }}
                        </div>
                    @endif
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mt-4">{{ $user->name }}</h2>
                <div class="flex justify-center flex-wrap gap-2 mt-2">
                    @if($user->grade)
                        <span class="bg-blue-50 text-blue-600 text-xs px-3 py-1 rounded-full font-bold">{{ $user->grade }}年生</span>
                    @endif
                    @if($user->department)
                        <span class="bg-green-50 text-green-600 text-xs px-3 py-1 rounded-full font-bold">{{ $user->department }}</span>
                    @endif
                </div>
            </div>

            <div class="mb-8">
                <h3 class="text-sm font-bold text-gray-400 mb-3 ml-1">連絡先</h3>
                <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm">
                    <div class="flex items-center justify-between p-4 border-b border-gray-50">
                        <div class="flex items-center text-gray-600">
                            <span class="w-8 text-indigo-400">📧</span>
                            <span class="text-sm font-medium">メール</span>
                        </div>
                        <span class="text-sm text-gray-800 font-semibold">{{ $user->email }}</span>
                    </div>
                    <div class="flex items-center justify-between p-4">
                        <div class="flex items-center text-gray-600">
                            <span class="w-8 text-pink-500">📞</span>
                            <span class="text-sm font-medium">電話</span>
                        </div>
                        <span class="text-sm text-gray-800 font-semibold">{{ $user->phone ?? '未設定' }}</span>
                    </div>
                </div>
            </div>

            <div class="mb-8">
                <h3 class="text-sm font-bold text-gray-400 mb-3 ml-1">サークル情報</h3>
                <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm">
                    <div class="flex items-center justify-between p-4 border-b border-gray-50">
                        <div class="flex items-center text-gray-600">
                            <span class="w-8 text-purple-600 text-xs">👤</span>
                            <span class="text-sm font-medium">役職</span>
                        </div>
                        <span class="text-sm text-gray-800 font-semibold">{{ $user->role ?? '一般' }}</span>
                    </div>
                    <div class="flex items-center justify-between p-4 border-b border-gray-50">
                        <div class="flex items-center text-gray-600">
                            <span class="w-8 text-indigo-400 text-xs">📚</span>
                            <span class="text-sm font-medium">学籍番号</span>
                        </div>
                        <span class="text-sm text-gray-800 font-semibold">{{ $user->student_number ?? '—' }}</span>
                    </div>
                    <div class="flex items-center justify-between p-4 border-b border-gray-50">
                        <div class="flex items-center text-gray-600">
                            <span class="w-8 text-blue-400 text-xs">📅</span>
                            <span class="text-sm font-medium">学部・学科</span>
                        </div>
                        <span class="text-sm text-gray-800 font-semibold">{{ $user->department ?? '学部・学科未設定' }}</span>
                    </div>
                    <div class="flex items-center justify-between p-4 border-b border-gray-50">
                        <div class="flex items-center text-gray-600">
                            <span class="w-8 text-blue-400 text-xs">📅</span>
                            <span class="text-sm font-medium">学年</span>
                        </div>
                        <span class="text-sm text-gray-800 font-semibold">{{ $user->grade ?? '学年未設定' }}</span>
                    </div>
                    <div class="flex items-center justify-between p-4 border-b border-gray-50">
                        <div class="flex items-center text-gray-600">
                            <span class="w-8 text-blue-400 text-xs">📅</span>
                            <span class="text-sm font-medium">加入日</span>
                        </div>
                        <span class="text-sm text-gray-800 font-semibold">{{ $user->joined_at ? $user->joined_at->format('Y/m/d') : '—' }}</span>
                    </div>
                    <div class="flex items-center justify-between p-4 border-b border-gray-50">
                        <div class="flex items-center text-gray-600">
                            <span class="w-8 text-blue-400 text-xs">📅</span>
                            <span class="text-sm font-medium">性別</span>
                        </div>
                        <span class="text-sm text-gray-800 font-semibold">{{ $user->gender ?? '性別未設定' }}</span>
                    </div>
                    <div class="flex items-center justify-between p-4">
                        <div class="flex items-center text-gray-600">
                            <span class="w-8 text-orange-300 text-xs">📝</span>
                            <span class="text-sm font-medium">備考</span>
                        </div>
                        <span class="text-sm {{ $user->notes ? 'text-gray-800 font-semibold' : 'text-gray-400' }}">{{ $user->notes ?? '—' }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-gray-100 rounded-xl p-5 border border-gray-200">
                <p class="text-xs text-gray-400 leading-relaxed text-center">
                    自分の情報を削除・編集するには<br>
                    <a href="{{ route('profile.edit') }}" class="text-pink-500 font-bold no-underline">マイページ</a>から操作してください。
                </p>
            </div>
        </div>
    </div>

    <x-bottom-nav />
</x-app-layout>