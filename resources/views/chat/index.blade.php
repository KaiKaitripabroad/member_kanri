<x-app-layout>
    <div class="py-12 pb-40 px-6">
        <div class="max-w-2xl mx-auto bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-indigo-600 p-6 text-white text-center">
                <h2 class="text-xl font-bold">チームチャット</h2>
                <p class="text-xs opacity-70">Slack #bh_20260307_team_j と連動中</p>
            </div>

            <div class="h-[500px] overflow-y-auto p-6 space-y-4 bg-gray-50" id="message-container">
                @forelse($messages as $msg)
                    <div class="flex flex-col {{ str_contains($msg['text'], auth()->user()->name) ? 'items-end' : 'items-start' }}">
                        <div class="max-w-[80%] p-4 rounded-2xl shadow-sm {{ str_contains($msg['text'], auth()->user()->name) ? 'bg-indigo-500 text-white rounded-tr-none' : 'bg-white text-gray-800 border border-gray-100 rounded-tl-none' }}">
                            <p class="text-sm">{{ $msg['text'] }}</p>
                        </div>
                        <span class="text-[10px] text-gray-400 mt-1">
                            {{ date('H:i', (int)$msg['ts']) }}
                        </span>
                    </div>
                @empty
                    <div class="text-center text-gray-400 mt-20">メッセージはまだありません</div>
                @endforelse
            </div>

            <div class="p-6 bg-white border-t border-gray-100">
                <form action="{{ route('chat.store') }}" method="POST" class="flex gap-3">
                    @csrf
                    <input 
                        type="text" 
                        name="message" 
                        required
                        placeholder="メッセージを入力..." 
                        class="flex-1 border-none bg-gray-100 rounded-2xl px-4 py-3 focus:ring-2 focus:ring-indigo-500"
                    >
                    <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-2xl font-bold hover:bg-indigo-700 transition-colors">
                        送信
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // メッセージエリアを一番下にスクロールさせる
        const container = document.getElementById('message-container');
        if (container) {
            container.scrollTop = container.scrollHeight;
        }

        // 5秒ごとにチェックしてリロードする
        setInterval(function() {
            const inputField = document.querySelector('input[name="message"]');
            
            // 入力欄が空（文字が入っていない）の時だけリロードを実行する
            if (inputField && inputField.value.trim() === "") {
                location.reload();
            }
        }, 5000);
    </script>
    @include('components.bottom-nav')
</x-app-layout>
