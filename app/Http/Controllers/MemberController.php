<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * ダッシュボード画面を表示する
     */
    public function dashboard()
    {
        $totalMembers = User::count();
        $newJoins = User::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->count();
        $unconfirmed = 0;
        $recentUpdates = User::latest()->take(3)->get();

        return view('dashboard', compact('totalMembers', 'newJoins', 'unconfirmed', 'recentUpdates'));
    }

    /**
     * メンバー一覧画面を表示する
     */
    public function index()
    {
        // データベースの全ユーザーを取得
        $allMembers = User::all();

        // メンバー一覧用のBlade（resources/views/members/index.blade.php）を表示
        return view('members.index', compact('allMembers'));
    }
}
