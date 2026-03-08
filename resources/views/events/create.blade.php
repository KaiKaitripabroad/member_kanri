<x-app-layout>
    <div class="py-6 px-4 pb-24">
        <div class="flex justify-between items-center mb-6">
            <a href="{{ route('events.index') }}" class="text-gray-600 flex items-center gap-1">
                <span class="text-xl">←</span> 戻る
            </a>
            <span class="font-bold text-gray-900">イベント投稿</span>
            <button type="submit" form="event-form" class="text-indigo-600 font-medium text-sm">投稿</button>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <form id="event-form" action="{{ route('events.store') }}" method="POST">
                @csrf

                <div class="space-y-5">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">イベント名 <span class="text-red-500">*</span></label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}"
                               class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-gray-900"
                               placeholder="例: 春の花見大会" required>
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label for="event_date" class="block text-sm font-medium text-gray-700 mb-1">開催日 <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <input type="date" id="event_date" name="event_date" value="{{ old('event_date') }}"
                                       class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-gray-900"
                                       required>
                                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">📅</span>
                            </div>
                            @error('event_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="start_time" class="block text-sm font-medium text-gray-700 mb-1">開始時刻</label>
                            <div class="relative">
                                <input type="time" id="start_time" name="start_time" value="{{ old('start_time') }}"
                                       class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-gray-900">
                                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">🕐</span>
                            </div>
                            @error('start_time')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700 mb-1">場所</label>
                        <input type="text" id="location" name="location" value="{{ old('location') }}"
                               class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-gray-900"
                               placeholder="例: 緑ヶ丘公園">
                        @error('location')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">説明・詳細</label>
                        <textarea id="description" name="description" rows="4"
                                  class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-gray-900"
                                  placeholder="イベントの内容や持ち物などを入力...">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-gray-700 mb-2">出欠確認</span>
                        <div class="flex gap-6">
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="radio" name="attendance_enabled" value="1" {{ old('attendance_enabled', true) ? 'checked' : '' }}
                                       class="rounded-full border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                <span class="ml-2 text-sm text-gray-700">有効にする</span>
                            </label>
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="radio" name="attendance_enabled" value="0" {{ old('attendance_enabled') === false || old('attendance_enabled') === '0' ? 'checked' : '' }}
                                       class="rounded-full border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                <span class="ml-2 text-sm text-gray-700">しない</span>
                            </label>
                        </div>
                        @error('attendance_enabled')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-8 space-y-3">
                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3.5 rounded-xl shadow-md transition">
                        イベントを投稿する
                    </button>
                    <a href="{{ route('events.index') }}" class="block text-center text-indigo-600 text-sm font-medium py-2">キャンセル</a>
                </div>
            </form>
        </div>
    </div>
    @include('components.bottom-nav')
</x-app-layout>
