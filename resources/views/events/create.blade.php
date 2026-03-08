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

                @if($errors->any())
                <div class="mb-4 p-4 rounded-xl bg-red-50 text-red-700 text-sm">
                    <p class="font-medium">入力内容をご確認ください。</p>
                    <ul class="mt-1 list-disc list-inside">
                        @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="space-y-5">

                    <!-- イベント名 -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            イベント名 <span class="text-red-500">*</span>
                        </label>

                        <input
                            type="text"
                            name="title"
                            value="{{ old('title') }}"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="例: 春の花見大会"
                            required>

                        @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>


                    <!-- 日付 -->
                    <div class="grid grid-cols-2 gap-3">

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                開催日
                            </label>

                            <input
                                type="date"
                                name="event_date"
                                value="{{ old('event_date') }}"
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                required>

                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                開始時刻
                            </label>

                            <input
                                type="time"
                                name="start_time"
                                value="{{ old('start_time') }}"
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">

                        </div>

                    </div>


                    <!-- 場所 -->
                    <div class="space-y-3">

                        <label class="block text-sm font-medium text-gray-700">
                            場所
                        </label>

                        <input
                            id="location"
                            name="location"
                            type="text"
                            value="{{ old('location') }}"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="場所を検索"
                            autocomplete="off">
                        <input type="hidden" name="latitude" id="latitude">
                        <input type="hidden" name="longitude" id="longitude">

                        <p class="text-xs text-gray-500">
                            場所を検索すると地図に表示されます
                        </p>

                        <div id="map"></div>

                    </div>


                    <!-- 説明 -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            説明
                        </label>

                        <textarea
                            name="description"
                            rows="4"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>

                    </div>

                    <!-- 出欠確認 -->
                    <div>
                        <span class="block text-sm font-medium text-gray-700 mb-2">出欠確認</span>
                        <div class="flex gap-6">
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="radio" name="attendance_enabled" value="1" {{ old('attendance_enabled', '1') === 1 || old('attendance_enabled', '1') === '1' ? 'checked' : '' }} class="rounded-full border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                <span class="ml-2 text-sm text-gray-700">有効にする</span>
                            </label>
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="radio" name="attendance_enabled" value="0" {{ old('attendance_enabled', '1') === 0 || old('attendance_enabled') === '0' ? 'checked' : '' }} class="rounded-full border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                <span class="ml-2 text-sm text-gray-700">しない</span>
                            </label>
                        </div>
                        @error('attendance_enabled')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                </div>


                <div class="mt-8">
                    <button
                        type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-xl">
                        イベントを投稿
                    </button>
                </div>

            </form>
        </div>
    </div>


    <!-- GoogleMap -->
    <script>
        let map
        let marker
        let autocomplete

        function initMap() {

            map = new google.maps.Map(document.getElementById("map"), {
                center: {
                    lat: 35.681236,
                    lng: 139.767125
                },
                zoom: 12
            })

            marker = new google.maps.Marker({
                map: map
            })

            const input = document.getElementById("location")

            autocomplete = new google.maps.places.Autocomplete(input)

            autocomplete.addListener("place_changed", function() {

                const place = autocomplete.getPlace()

                if (!place.geometry) {
                    return
                }

                const lat = place.geometry.location.lat()
                const lng = place.geometry.location.lng()

                map.setCenter(place.geometry.location)
                map.setZoom(15)

                marker.setPosition(place.geometry.location)

                document.getElementById("latitude").value = lat
                document.getElementById("longitude").value = lng
            })
        }
    </script>


    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDI2muxAgXjoYKsOtCI1CxQ54LykobXMag&libraries=places&callback=initMap"
        async
        defer>
    </script>


    <style>
        #map {
            width: 100%;
            height: 300px;
            border-radius: 12px;
            margin-top: 10px;
        }
    </style>


    @include('components.bottom-nav')

</x-app-layout>