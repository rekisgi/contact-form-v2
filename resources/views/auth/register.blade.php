<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>FashionablyLate - 会員登録</title>
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>
    <header class="header">
        <h1 class="header__logo">FashionablyLate</h1>
        <a class="header__link" href="/login">login</a>
    </header>

    <main>
        <div class="auth__content">
            <div class="auth__heading">
                <h2>Register</h2>
            </div>
<form class="form" action="/register" method="post">
@csrf

<div class="form__group">
    <div class="form__group-title">
    <span class="form__label--item">お名前</span>
</div>
<div class="form__group-content">
    <input type="text" name="name" placeholder="例: 山田 太郎" value="{{ old('name') }}">
    <div class="form__error">
    @error('name') <p>{{ $message }}
    </p> @enderror
        </div>
     </div>
</div>

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
                    <button class="form__button-submit" type="submit">登録</button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>