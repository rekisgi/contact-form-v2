public function run()
{
    \App\Models\Category::create(['content' => 'ご意見']);
    \App\Models\Category::create(['content' => 'ご質問']);
    \App\Models\Category::create(['content' => 'その他']);
}