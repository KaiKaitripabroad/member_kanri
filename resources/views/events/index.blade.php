<x-app-layout>
    <div class="py-6 px-4 pb-24">
        @if(session('error'))
            <div class="mb-4 p-4 rounded-xl bg-red-50 text-red-700 text-sm">{{ session('error') }}</div>
        @endif
        @if(session('success'))
            <div class="mb-4 p-4 rounded-xl bg-green-50 text-green-700 text-sm">{{ session('success') }}</div>
        @endif
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">イベント</h1>
            <a href="{{ route('events.create') }}" class="text-indigo-600 font-medium text-sm flex items-center gap-1">
                <span class="text-lg leading-none">+</span> 投稿
            </a>
        </div>

        <div class="flex gap-2 mb-6 overflow-x-auto pb-1">
            <a href="{{ route('events.index', ['tab' => 'upcoming']) }}"
               class="shrink-0 px-4 py-2 rounded-full text-sm font-medium transition
                    {{ ($tab ?? 'upcoming') === 'upcoming' ? 'bg-indigo-100 text-indigo-600' : 'bg-gray-100 text-gray-500' }}">
                予定({{ $upcomingCount }})
            </a>
            <a href="{{ route('events.index', ['tab' => 'past']) }}"
               class="shrink-0 px-4 py-2 rounded-full text-sm font-medium transition
                    {{ ($tab ?? '') === 'past' ? 'bg-indigo-100 text-indigo-600' : 'bg-gray-100 text-gray-500' }}">
                過去({{ $pastCount }})
            </a>
            <a href="{{ route('events.index', ['tab' => 'all']) }}"
               class="shrink-0 px-4 py-2 rounded-full text-sm font-medium transition
                    {{ ($tab ?? '') === 'all' ? 'bg-indigo-100 text-indigo-600' : 'bg-gray-100 text-gray-500' }}">
                すべて({{ $totalCount }})
            </a>
        </div>

        <div class="space-y-4">
            @forelse($events as $event)
                @php
                    $isPast = $event->event_date->isPast();
                    $attendingCount = $event->attendances->where('status', \App\Models\Attendance::STATUS_ATTENDING)->count();
                    $pendingCount = $event->attendances->where('status', \App\Models\Attendance::STATUS_PENDING)->count();
                    $hasAttendance = $event->attendance_enabled && $event->attendances->isNotEmpty();
                @endphp
                <a href="{{ route('events.show', $event) }}" class="block bg-white rounded-xl border border-gray-100 shadow-sm p-4 flex items-stretch gap-4 hover:bg-gray-50 transition">
                    <div class="shrink-0 w-14 h-14 rounded-lg bg-indigo-100 text-indigo-600 flex flex-col items-center justify-center">
                        <span class="text-[10px] font-bold uppercase leading-tight">{{ $event->event_date->format('M') }}</span>
                        <span class="text-xl font-bold leading-tight -mt-0.5">{{ $event->event_date->format('d') }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-bold text-gray-900 truncate">{{ $event->title }}</h3>
                        <p class="text-sm text-gray-500 mt-0.5 flex items-center gap-1">
                            @if($event->location)
                                <span class="text-red-500">📍</span> {{ $event->location }}
                            @endif
                            @if($event->location && $event->start_time) · @endif
                            @if($event->start_time)
                                {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}～
                            @elseif($isPast)
                                終了
                            @endif
                        </p>
                        <div class="flex flex-wrap gap-1.5 mt-2">
                            @if($isPast)
                                <span class="px-2.5 py-0.5 rounded-full text-xs bg-gray-100 text-gray-500">終了</span>
                            @elseif($event->attendance_enabled && $hasAttendance)
                                <span class="px-2.5 py-0.5 rounded-full text-xs bg-indigo-100 text-indigo-600">参加{{ $attendingCount }}</span>
                                @if($pendingCount > 0)
                                    <span class="px-2.5 py-0.5 rounded-full text-xs bg-orange-100 text-orange-600">未回答{{ $pendingCount }}</span>
                                @endif
                            @elseif($event->attendance_enabled)
                                <span class="px-2.5 py-0.5 rounded-full text-xs bg-gray-100 text-gray-500">集計前</span>
                            @endif
                        </div>
                    </div>
                    <div class="shrink-0 flex items-center text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </div>
                </a>
            @empty
                <div class="text-center py-12 text-gray-500">
                    <p>イベントがありません</p>
                    <a href="{{ route('events.create') }}" class="mt-2 inline-block text-indigo-600 font-medium">最初のイベントを投稿する</a>
                </div>
            @endforelse
        </div>
    </div>
    @include('components.bottom-nav')
</x-app-layout>
