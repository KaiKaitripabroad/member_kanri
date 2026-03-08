<x-app-layout>
    <div class="py-6 px-4 pb-24">
        <div class="flex justify-between items-center mb-6">
            <a href="{{ route('events.index') }}" class="text-gray-600 flex items-center gap-1">
                <span class="text-xl">←</span> 戻る
            </a>
            <a href="{{ route('events.edit', $event) }}" class="text-indigo-600 font-medium text-sm">編集</a>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h1 class="text-xl font-bold text-gray-900 mb-4">{{ $event->title }}</h1>
            <dl class="space-y-3 text-sm">
                <div class="flex">
                    <dt class="w-24 text-gray-500 shrink-0">開催日</dt>
                    <dd class="text-gray-900">{{ $event->event_date->format('Y年n月j日') }}</dd>
                </div>
                @if($event->start_time)
                    <div class="flex">
                        <dt class="w-24 text-gray-500 shrink-0">開始時刻</dt>
                        <dd class="text-gray-900">{{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}</dd>
                    </div>
                @endif
                @if($event->location)
                    <div class="flex">
                        <dt class="w-24 text-gray-500 shrink-0">場所</dt>
                        <dd class="text-gray-900">{{ $event->location }}</dd>
                    </div>
                @endif
                @if($event->description)
                    <div class="pt-2 border-t border-gray-100">
                        <dt class="text-gray-500 mb-1">説明・詳細</dt>
                        <dd class="text-gray-900 whitespace-pre-wrap">{{ $event->description }}</dd>
                    </div>
                @endif
            </dl>
            <div class="mt-6 flex gap-3">
                <a href="{{ route('events.edit', $event) }}" class="flex-1 text-center bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 rounded-xl">編集</a>
                <form action="{{ route('events.destroy', $event) }}" method="POST" class="flex-1" onsubmit="return confirm('このイベントを削除しますか？');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full text-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2.5 rounded-xl">削除</button>
                </form>
            </div>
        </div>
    </div>
    @include('components.bottom-nav')
</x-app-layout>
