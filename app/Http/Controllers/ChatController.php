<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; // ← Slack APIとの通信に必要です

class ChatController extends Controller
{
    private $token;
    private $channel;

    public function __construct()
    {
        // .env に設定した値を読み込みます
        $this->token = env('SLACK_BOT_TOKEN');
        $this->channel = env('SLACK_CHAT_CHANNEL');
    }

    // チャット画面の表示（履歴取得）
    public function index()
    {
        $response = Http::withToken($this->token)
            ->get('https://slack.com/api/conversations.history', [
                'channel' => $this->channel,
                'limit'   => 20,
            ]);

        $messages = $response->json()['messages'] ?? [];
        
        // メッセージを時系列（古い順）に並び替え
        $messages = array_reverse($messages);

        return view('chat.index', compact('messages'));
    }

    // メッセージの送信
    public function store(Request $request)
    {
        $request->validate(['message' => 'required']);

        Http::withToken($this->token)
            ->post('https://slack.com/api/chat.postMessage', [
                'channel' => $this->channel,
                'text'    => auth()->user()->name . ": " . $request->message,
            ]);

        return back();
    }
}