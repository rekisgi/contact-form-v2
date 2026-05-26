<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Category;
use App\Http\Requests\ContactRequest; 

class ContactController extends Controller
{
    public function admin(Request $request)
    {
        $query = Contact::with('category');

        // 名前・メールアドレスの検索
        if ($request->has('keyword') && $request->filled('keyword')) {
            $keyword = $request->input('keyword');
            $query->where(function($q) use ($keyword) {
                $q->where('last_name', 'like', "%{$keyword}%")
                  ->orWhere('first_name', 'like', "%{$keyword}%")
                  ->orWhere('email', 'like', "%{$keyword}%");
            });
        }

        // 性別の検索（💡 全て「all」のときは絞り込みをスキップする修正を入れました）
        if ($request->has('gender') && $request->filled('gender') && $request->input('gender') !== 'all') {
            $query->where('gender', $request->input('gender'));
        }

        // お問い合わせ種類の検索
        if ($request->has('category_id') && $request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        // 日付の検索
        if ($request->has('date') && $request->filled('date')) {
            $query->whereDate('created_at', $request->input('date'));
        }

        // ページネーション（1ページ7件）
        $contacts = $query->paginate(7);

        // 💡 画面のセレクトボックス用のカテゴリ一覧
        $categories = Category::all();

        return view('admin', compact('contacts', 'categories'));
    }

    // 💡 以下の download メソッドを丸ごと追記してください
    public function download(Request $request)
    {
        $query = Contact::with('category');

        // 画面と同じ検索条件でデータを絞り込む
        if ($request->has('keyword') && $request->filled('keyword')) {
            $keyword = $request->input('keyword');
            $query->where(function($q) use ($keyword) {
                $q->where('last_name', 'like', "%{$keyword}%")
                  ->orWhere('first_name', 'like', "%{$keyword}%")
                  ->orWhere('email', 'like', "%{$keyword}%");
            });
        }

        if ($request->has('gender') && $request->filled('gender') && $request->input('gender') !== 'all') {
            $query->where('gender', $request->input('gender'));
        }

        if ($request->has('category_id') && $request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        if ($request->has('date') && $request->filled('date')) {
            $query->whereDate('created_at', $request->input('date'));
        }

        // 💡 ページネーションではなく、条件に合う全件を取得する
        $contacts = $query->get();

        // CSVファイルを作成
        $csvHeader = ['id', 'お名前', '性別', 'メールアドレス', 'お問い合わせの種類', 'お問い合わせ内容', '登録日時'];
        
        $callback = function() use ($contacts, $csvHeader) {
            $file = fopen('php://output', 'w');
            
            // 💡 WindowsのExcelで開いても文字化けしないように「BOM」を出力
            fputs($file, pack('C*', 0xEF, 0xBB, 0xBF));
            
            // ヘッダー（1行目）を書き込み
            fputcsv($file, $csvHeader);

            // データを1行ずつ書き込み
            foreach ($contacts as $contact) {
                $gender = $contact->gender == 1 ? '男性' : ($contact->gender == 2 ? '女性' : 'その他');
                
                fputcsv($file, [
                    $contact->id,
                    $contact->last_name . ' ' . $contact->first_name,
                    $gender,
                    $contact->email,
                    $contact->category ? $contact->category->content : '',
                    $contact->detail,
                    $contact->created_at->format('Y-m-d H:i:s'),
                ]);
            }
            fclose($file);
        };

        // レスポンスヘッダーの設定（ファイルをダウンロードさせるための命令）
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=contacts_" . date('YmdHis') . ".csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        return response()->stream($callback, 200, $headers);
    }

    public function index()
    {
        $categories = Category::all();
        return view('index', compact('categories'));
    }

    public function confirm(ContactRequest $request)
    {
        $contact = $request->all();
        return view('confirm', compact('contact'));
    }

    public function store(Request $request)
    {
        $contact = $request->only([
            'last_name', 'first_name', 'gender', 'email', 
            'tel1', 'tel2', 'tel3', 'address', 'building', 
            'category_id', 'detail'
        ]);

        $contact['tel'] = $contact['tel1'] . $contact['tel2'] . $contact['tel3'];

        Contact::create($contact);

        return view('thanks');
    }
}