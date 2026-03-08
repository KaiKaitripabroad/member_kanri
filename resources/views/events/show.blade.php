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
                <div class="flex">
                    <dt class="w-24 text-gray-500 shrink-0">開始時刻</dt>
                    <dd class="text-gray-900">{{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}</dd>
                </div>
                @endif
                @if($event->latitude && $event->longitude && $event->location)
                <div>
                    <div class="flex">
                        <dt class="w-24 text-gray-500 shrink-0">場所</dt>
                        <dd class="text-gray-900">
                            <a href="https://maps.google.com/?q={{ $event->latitude }},{{ $event->longitude }}" target="_blank" class="text-indigo-600 hover:underline">
                                {{ $event->location }}
                            </a>
                        </dd>
                    </div>
                    <div id="map" class="mt-4"></div>
                </div>
                @endif
                @if($event->description)
                <div class="pt-2 border-t border-gray-100">
                    <dt class="text-gray-500 mb-1">説明・詳細</dt>
                    <dd class="text-gray-900 whitespace-pre-wrap">{{ $event->description }}</dd>
                </div>
                @endif
                {{-- 場所と説明は省略（そのままのロジックでOK） --}}
            </dl>

            @if($event->attendance_enabled)
            <div class="mt-6 pt-4 border-t border-gray-100">
                <h3 class="text-sm font-bold text-gray-700 mb-3">出欠状況</h3>
                <div class="flex flex-wrap gap-2 mb-3">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-700">参加 {{ $attendingCount }}人</span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700">不参加 {{ $notAttendingCount }}人</span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-700">未回答 {{ $pendingCount }}人</span>
                </div>
                <p class="text-xs text-gray-500">出欠の入力・変更は「出欠確認」から行えます。</p>
            </div>
            @endif

            {{-- 3. ボタンを控えめに（右寄せ、または左寄せでコンパクトに） --}}
            {{-- ボタンエリア：justify-start を使い、中身の幅に合わせる --}}
            <div class="mt-10 flex items-center justify-start gap-4">
             @if($event->attendance_enabled)
                    {{-- inline-block を指定して、縦長になるのを防ぎます --}}
                    <a href="{{ route('events.attendance', $event) }}" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-2xl shadow-sm transition-all active:scale-95 text-center">
                       出欠確認
                     </a>
                @endif
    
             <form action="{{ route('events.destroy', $event) }}" method="POST" onsubmit="return confirm('このイベントを削除しますか？');">
                        @csrf
                @method('DELETE')
                {{-- w-full を外すか、親のformに幅を持たせないことで主張を抑えます --}}
                    <button type="submit" class="text-gray-400 hover:text-red-500 hover:bg-red-50 px-4 py-3 rounded-2xl text-sm font-medium transition-all">
                        削除する
                    </button>
                </form>
            </div>
        </div>
    </div>
    <script>
    window.initMap = function () {

    const lat = {{ $event->latitude ?? 0 }};
    const lng = {{ $event->longitude ?? 0 }};

    const location = { lat: lat, lng: lng };

    const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 15,
        center: location
    });

    new google.maps.Marker({
        position: location,
        map: map
    });
}
</script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDI2muxAgXjoYKsOtCI1CxQ54LykobXMag&callback=initMap"
        async
        defer>
    </script>
    <style>
        #map {
            width: 100%;
            height: 300px;
            border-radius: 12px;
        }
    </style>
    @include('components.bottom-nav')
</x-app-layout>