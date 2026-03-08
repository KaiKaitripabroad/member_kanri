<x-app-layout>
    <div class="py-6 px-4 pb-24">
        <div class="flex justify-between items-center mb-6">
            <a href="{{ route('events.show', $event) }}" class="text-gray-600 flex items-center gap-1">
                <span class="text-xl">←</span> 戻る
            </a>
            <span class="font-bold text-gray-900">出欠確認</span>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 mb-4">
            <h2 class="font-bold text-gray-900">{{ $event->title }}</h2>
            <p class="text-sm text-gray-500 mt-1">{{ $event->event_date->format('Y年n月j日') }}@if($event->start_time) {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}@endif</p>
        </div>

        @if(session('success'))
            <div class="mb-4 p-4 rounded-xl bg-green-50 text-green-700 text-sm">{{ session('success') }}</div>
        @endif

        <form action="{{ route('events.attendance.update', $event) }}" method="POST">
            @csrf
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-4 py-3 border-b border-gray-100 bg-gray-50">
                    <p class="text-sm font-medium text-gray-700">メンバーごとの出欠を選択してください</p>
                </div>
                <ul class="divide-y divide-gray-100">
                    @forelse($event->attendances as $attendance)
                        <li class="flex items-center justify-between gap-4 p-4">
                            <div class="min-w-0">
                                <p class="font-medium text-gray-900 truncate">{{ $attendance->member->name ?? 'メンバー' }}</p>
                                @if($attendance->member && $attendance->member->department)
                                    <p class="text-xs text-gray-500">{{ $attendance->member->department }} {{ $attendance->member->grade }}年</p>
                                @endif
                            </div>
                            <div class="flex gap-2 shrink-0">
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="radio" name="attendances[{{ $attendance->id }}]" value="ATTENDING" class="rounded-full border-gray-300 text-indigo-600 focus:ring-indigo-500" {{ $attendance->status === \App\Models\Attendance::STATUS_ATTENDING ? 'checked' : '' }}>
                                    <span class="ml-1 text-xs text-gray-700">参加</span>
                                </label>
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="radio" name="attendances[{{ $attendance->id }}]" value="NOT_ATTENDING" class="rounded-full border-gray-300 text-indigo-600 focus:ring-indigo-500" {{ $attendance->status === \App\Models\Attendance::STATUS_NOT_ATTENDING ? 'checked' : '' }}>
                                    <span class="ml-1 text-xs text-gray-700">不参加</span>
                                </label>
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="radio" name="attendances[{{ $attendance->id }}]" value="PENDING" class="rounded-full border-gray-300 text-indigo-600 focus:ring-indigo-500" {{ $attendance->status === \App\Models\Attendance::STATUS_PENDING ? 'checked' : '' }}>
                                    <span class="ml-1 text-xs text-gray-700">未回答</span>
                                </label>
                            </div>
                        </li>
                    @empty
                        <li class="p-6 text-center text-gray-500 text-sm">出欠対象のメンバーがいません</li>
                    @endforelse
                </ul>
                @if($event->attendances->isNotEmpty())
                    <div class="p-4 border-t border-gray-100 bg-gray-50">
                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 rounded-xl">出欠を保存</button>
                    </div>
                @endif
            </div>
        </form>
    </div>
    @include('components.bottom-nav')
</x-app-layout>
