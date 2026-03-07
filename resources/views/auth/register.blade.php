<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>アカウント作成</title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/css/register.css') }}">
</head>
<body>
    <div class="card">
        <button class="back-btn" onclick="history.back()">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M15 18l-6-6 6-6"/>
            </svg>
            アカウント作成
        </button>

        <p class="subtitle"><br>新しいアカウントを作成します。</p>

        <form method="POST" action="{{ route('register') }}" id="registerForm" novalidate>
            @csrf

            <div class="form-group">
                <label for="name">氏名</label>
                <input type="text" id="name" name="name" placeholder="山田 太郎" value="{{ old('name') }}" required autofocus>
                @if($errors->has('name'))
                    <p class="error-msg">{{ $errors->first('name') }}</p>
                @endif
            </div>

            <div class="form-group">
                <label for="email">メールアドレス</label>
                <input type="email" id="email" name="email" placeholder="example@circle.jp" value="{{ old('email') }}" required>
                @if($errors->has('email'))
                    <p class="error-msg">{{ $errors->first('email') }}</p>
                @endif
            </div>

            <div class="form-group">
                <label for="password">パスワード</label>
                <input type="password" id="password" name="password" placeholder="8文字以上" required>
                <p class="hint">英数字8文字以上</p>
                @if($errors->has('password'))
                    <p class="error-msg">{{ $errors->first('password') }}</p>
                @endif
            </div>

            <div class="form-group">
                <label for="password_confirmation">パスワード（確認）</label>
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="もう一度入力" required>
                <p class="error-msg" id="passwordError" style="display:none;">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    パスワードが一致しません
                </p>
            </div>

            <button type="submit" class="submit-btn">アカウントを作成</button>
        </form>

        <div class="divider"></div>
        <a class="login-link" href="{{ route('login') }}">すでにアカウントをお持ちの方</a>
    </div>

    <script src="{{ asset('/js/register.js') }}"></script>
</body>
</html>