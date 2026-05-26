<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>FashionablyLate - ログイン</title>
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>
    <header class="header">
        <h1 class="header__logo">FashionablyLate</h1>
        <a class="header__link" href="/register">register</a>
    </header>

    <main>
        <div class="auth__content">
            <div class="auth__heading">
                <h2>Login</h2>
            </div>
<form class="form" action="/login" method="post">
@csrf

<div class="form__group">
 <div class="form__group-title">
    <span class="form__label--item">メールアドレス</span>
</div>
<div class="form__group-content">
    <input type="email" name="email" placeholder="例: test@example.com" value="{{ old('email') }}">
     <div class="form__error">
 @error('email') <p>{{ $message }}</p> @enderror
</div>
</div>
</div>

<div class="form__group">
    <div class="form__group-title">
        <span class="form__label--item">パスワード</span>
    </div>
 <div class="form__group-content">
    <input type="password" name="password" placeholder="例: coachtech1106">
        <div class="form__error">
 @error('password') <p>{{ $message }}</p> @enderror
        </div>
    </div>
</div>

<div class="form__button">
    <button class="form__button-submit" type="submit">ログイン</button>
    </div>
</form>
        </div>
    </main>
</body>
</html>