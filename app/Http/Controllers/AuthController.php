<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; 
use Illuminate\Support\Facades\Hash; 
use Illuminate\Support\Facades\Auth; 

class AuthController extends Controller
{
    /**
     * ユーザー登録画面を表示
     */
    public function showRegister()
    {
        return view('auth.register'); 
    }

    /**
     * ログイン画面を表示
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * ユーザー登録処理（FN011, FN012, FN013, FN014）
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ], [
            'name.required' => 'お名前を入力してください',
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスはメール形式で入力してください', // 💡要件通りに完全一致
            'email.unique' => 'このメールアドレスは既に登録されています',
            'password.required' => 'パスワードを入力してください',
            'password.min' => 'パスワードは8文字以上で入力してください',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect('/login');
    }

    /**
     * ログイン処理（FN017, FN018, FN019, FN020）
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスはメール形式で入力してください', // 💡要件通りに完全一致
            'password.required' => 'パスワードを入力してください',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect('/admin');
        }

        return back()->withErrors([
            'email' => 'ログイン情報が登録されていません', // 💡要件通りに完全一致
        ])->withInput();
    } // 👈 ここで綺麗にloginメソッドを閉じています！

    /**
     * ログアウト処理（FN027）
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    /**
     * 管理画面の初期表示用（FN021）
     */
    public function index()
    {
        return view('admin');
    }
}