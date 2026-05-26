<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>FashionablyLate - 管理画面</title>
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
    <header class="header">
        <h1 class="header__logo">FashionablyLate</h1>
        <button class="header__link" style="background: none; border: none; cursor: pointer;">logout</button>
    </header>

    <main style="background-color: #f9f8f6; padding: 60px 20px;">
        <div style="max-width: 1200px; margin: 0 auto; text-align: center;">
            <h2 style="font-size: 24px; color: #8b7f73; margin-bottom: 30px;">Admin</h2>
            
            <form class="search-form" action="/admin/search" method="get">
                @csrf
                
                <div class="search-form__item">
                    <input type="text" name="keyword" placeholder="名前やメールアドレスを入力してください" value="{{ request('keyword') }}">
                </div>

                <div class="search-form__item">
                    <select name="gender">
                        <option value="">性別</option>
                        <option value="all" {{ request('gender') == 'all' ? 'selected' : '' }}>全て</option>
                        <option value="1" {{ request('gender') == '1' ? 'selected' : '' }}>男性</option>
                        <option value="2" {{ request('gender') == '2' ? 'selected' : '' }}>女性</option>
                        <option value="3" {{ request('gender') == '3' ? 'selected' : '' }}>その他</option>
                    </select>
                </div>

                <div class="search-form__item">
                    <select name="category_id">
                        <option value="">お問い合わせの種類</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->content }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="search-form__item">
                    <input type="date" name="date" value="{{ request('date') }}">
                </div>

                <div class="search-form__actions" style="display: flex; align-items: center; gap: 10px;">
                    <button type="submit" class="search-form__btn-submit">検索</button>
                    <a href="{{ url('/admin/download') }}?{{ http_build_query(request()->query()) }}" class="search-form__btn-csv" style="background-color: #8b7f73; color: #fff; padding: 10px 20px; border-radius: 4px; text-decoration: none; font-size: 14px;">CSV出力</a>
                    <a href="/admin" class="search-form__btn-reset">リセット</a>
                </div>
            </form>

            <div class="admin-table">
                <table class="admin-table__inner">
                    <tr class="admin-table__row">
                        <th class="admin-table__label">お名前</th>
                        <th class="admin-table__label">性別</th>
                        <th class="admin-table__label">メールアドレス</th>
                        <th class="admin-table__label">お問い合わせ内容</th>
                        <th class="admin-table__label"></th>
                    </tr>

                    @foreach ($contacts as $contact)
                        <tr class="admin-table__row">
                            <td class="admin-table__text">
                                {{ $contact->last_name }}&nbsp;{{ $contact->first_name }}
                            </td>
                            <td class="admin-table__text">
                                @if($contact->gender == 1) 男性
                                @elseif($contact->gender == 2) 女性
                                @else その他
                                @endif
                            </td>
                            <td class="admin-table__text">
                                {{ $contact->email }}
                            </td>
                            <td class="admin-table__text">
                                {{ Str::limit($contact->detail, 40, '...') }}
                            </td>
                            <td class="admin-table__text">
                                <button class="admin-table__detail-btn" onclick="openModal({{ $contact->id }})">詳細</button>
                            </td>
                        </tr>
                    @endforeach
                </table>

                <div class="admin-table__pagination">
                    {{ $contacts->links('pagination::bootstrap-4') }}
                </div>
            </div>

        </div>
    </main>

    @foreach ($contacts as $contact)
    <div id="modal-{{ $contact->id }}" class="modal-overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; justify-content: center; align-items: center;">
        <div style="background: #fff; padding: 40px; width: 600px; max-width: 90%; border-radius: 4px; position: relative; text-align: left;">
            
            <button onclick="closeModal({{ $contact->id }})" style="position: absolute; top: 20px; right: 20px; background: none; border: none; font-size: 24px; cursor: pointer; color: #8b7f73;">&times;</button>
            
            <h3 style="font-size: 20px; color: #8b7f73; text-align: center; margin-bottom: 30px; font-weight: normal;">お問合せ詳細</h3>
            
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
                <tr style="border-bottom: 1px solid #eee;">
                    <th style="padding: 12px 0; color: #8b7f73; font-weight: normal; width: 30%;">お名前</th>
                    <td style="padding: 12px 0;">{{ $contact->last_name }}&nbsp;{{ $contact->first_name }}</td>
                </tr>
                <tr style="border-bottom: 1px solid #eee;">
                    <th style="padding: 12px 0; color: #8b7f73; font-weight: normal;">性別</th>
                    <td style="padding: 12px 0;">
                        @if($contact->gender == 1) 男性 @elseif($contact->gender == 2) 女性 @else その他 @endif
                    </td>
                </tr>
                <tr style="border-bottom: 1px solid #eee;">
                    <th style="padding: 12px 0; color: #8b7f73; font-weight: normal;">メールアドレス</th>
                    <td style="padding: 12px 0;">{{ $contact->email }}</td>
                </tr>
                <tr style="border-bottom: 1px solid #eee;">
                    <th style="padding: 12px 0; color: #8b7f73; font-weight: normal;">お届け日</th>
                    <td style="padding: 12px 0;">{{ $contact->created_at->format('Y/m/d') }}</td>
                </tr>
                <tr>
                    <th style="padding: 12px 0; color: #8b7f73; font-weight: normal; vertical-align: top;">お問合せ内容</th>
                    <td style="padding: 12px 0; white-space: pre-wrap;">{{ $contact->detail }}</td>
                </tr>
            </table>
        </div>
    </div>
    @endforeach

    <script>
    function openModal(id) {
        document.getElementById('modal-' + id).style.display = 'flex';
    }

    // 💡 閉じ忘れていた記述や関数をすべて完璧に補完しました
    function closeModal(id) {
        document.getElementById('modal-' + id).style.display = 'none';
    }
    </script>
</body>
</html>