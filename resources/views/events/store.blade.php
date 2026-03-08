<x-app-layout>
    <div class="py-8 px-6 pb-24">
        <h1 class="text-2xl font-bold">イベント作成</h1>
        <p>イベント作成が完了しました。</p>
        <a href="{{ route('events.index') }}" class="mt-4 inline-block bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-700">戻る</a>
    </div>
    @include('components.bottom-nav')
</x-app-layout>