<x-app-layout>
    <div class="py-6 px-4 pb-24 max-w-2xl mx-auto"> {{-- 中央寄せで読みやすく --}}
        <div class="flex justify-between items-center mb-8"> {{-- 余白を広げた --}}
            <a href="{{ route('events.index') }}" class="text-gray-500 hover:text-gray-700 flex items-center gap-1 transition-colors">
                <span class="text-xl">←</span> 戻る
            </a>
            <a href="{{ route('events.edit', $event) }}" class="text-indigo-600 hover:underline font-medium text-sm">編集</a>
        </div>

        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-8"> {{-- 角丸とパディングを強化 --}}
            {{-- 1. タイトルを大きく --}}
            <h1 class="text-3xl font-extrabold text-gray-900 mb-6 tracking-tight">{{ $event->title }}</h1>
            
            {{-- 2. 詳細情報を大きく、ゆったり配置 --}}
            <dl class="space-y-4 text-base"> {{-- text-smからbaseへ --}}
                <div class="flex items-center">
                    <dt class="w-24 text-gray-400 shrink-0 font-medium">開催日</dt>
                    <dd class="text-gray-900 font-semibold">{{ $event->event_date->format('Y年n月j日') }}</dd>
                </div>
                @if($event->start_time)
                    <div class="flex items-center">
                        <dt class="w-24 text-gray-400 shrink-0 font-medium">開始時刻</dt>
                        <dd class="text-gray-900 font-semibold">{{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}</dd>
                    </div>
                @endif
                {{-- 場所と説明は省略（そのままのロジックでOK） --}}
            </dl>

            @if($event->attendance_enabled)
                <div class="mt-8 pt-6 border-t border-gray-50">
                    <h3 class="text-xs uppercase tracking-widest font-bold text-gray-400 mb-4">出欠状況</h3>
                    <div class="flex flex-wrap gap-3 mb-4">
                        <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold bg-indigo-50 text-indigo-600">参加 {{ $attendingCount }}人</span>
                        <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold bg-gray-50 text-gray-600">不参加 {{ $notAttendingCount }}人</span>
                        <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold bg-orange-50 text-orange-600 text-opacity-80">未回答 {{ $pendingCount }}人</span>
                    </div>
                </div>
            @endif

            {{-- 3. ボタンを控えめに（右寄せ、または左寄せでコンパクトに） --}}
            <div class="mt-10 flex items-center justify-start gap-4">
                @if($event->attendance_enabled)
                    <a href="{{ route('events.attendance', $event) }}" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-2xl shadow-sm shadow-indigo-200 transition-all active:scale-95">
                        出欠確認
                    </a>
                @endif
                
                <form action="{{ route('events.destroy', $event) }}" method="POST" onsubmit="return confirm('このイベントを削除しますか？');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-gray-400 hover:text-red-500 hover:bg-red-50 px-4 py-3 rounded-2xl text-sm font-medium transition-all">
                        削除する
                    </button>
                </form>
            </div>
        </div>
    </div>
    @include('components.bottom-nav')
</x-app-layout>