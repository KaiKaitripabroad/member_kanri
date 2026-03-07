<x-guest-layout>
    
<link rel="stylesheet" href="{{ asset('login.css') }}">
    <div class="login-container">
        <div class="login-header">
            <h2 class="login-title">おかえりなさい👏</h2>
            <p class="login-subtitle">サークル管理アカウントにログイン</p>
            <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label class="form-label">メールアドレス</label>
                <input type="email" name="email" class="form-input" placeholder="example@circle.jp" required autofocus>
            </div>

            <div class="form-group">
                <label class="form-label">パスワード</label>
                <input type="password" name="password" class="form-input" placeholder="••••••••" required>
            </div>

            

            <button type="submit" class="btn btn-login">
                ログイン
            </button>
            
            <div class="divider">
                <span>または</span>
            </div>

            <a href="{{ route('register') }}" class="btn btn-register">
                新規アカウントを作成
            </a>
        </form>
    </div>
</x-guest-layout>
