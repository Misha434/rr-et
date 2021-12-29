<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Category;
use Illuminate\Support\Carbon;
use App\Http\Requests\CreateScript;
use Illuminate\Support\Facades\Validator;

class ScriptTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed('CategoriesTableSeeder');
    }

    /**
     * ネタ内容が空欄の場合はバリデーションエラー
     * @test
     */
    public function content_is_not_available_in_0_charactors(): void
    {
        $data = [
            'content' => '',
            'category_id' => 1,
        ];
        $request = new CreateScript();
        $rules = $request->rules();

        $validator = Validator::make($data, $rules);

        $result = $validator->passes();
        $this->assertFalse($result);
        $expectedFailed = [
            'content' => ['Required' => [],],
        ];
        $this->assertEquals($expectedFailed, $validator->failed());
    }

    /**
     * カテゴリ名が1文字の場合は登録可能
     * @test
     */
    public function content_is_available_in_1_charactor(): void
    {
        $data = [
            'content' => 'X',
            'category_id' => 1,
        ];
        $request = new CreateScript();
        $rules = $request->rules();

        $validator = Validator::make($data, $rules);

        $result = $validator->passes();
        $this->assertTrue($result);
    }

    /**
     * カテゴリ名が100文字の場合は登録可能
     * @test
     */
    public function content_is_available_in_100_charactors(): void
    {
        $data = [
            'content' => '私は翌日どうしてもその講演人というものの限りがしですん。同時に半分に話方はまあ大きな演説らしいだまでをありてならたには満足構わんでて、そうにも使いたたうまし。火事にしうのも人知れず生涯をどうぞですでで',
            'category_id' => 1,
        ];
        $request = new CreateScript();
        $rules = $request->rules();

        $validator = Validator::make($data, $rules);

        $result = $validator->passes();
        $this->assertTrue($result);
    }
    
    /**
     * カテゴリ名が101文字の場合はバリデーションエラー
     * @test
     */
    public function content_is_not_available_in_101_charactors(): void
    {
        $data = [
            'content' => '私は翌日どうしてもその講演人というものの限りがしですん。同時に半分に話方はまあ大きな演説らしいだまでをありてならたには満足構わんでて、そうにも使いたたうまし。火事にしうのも人知れず生涯をどうぞですでで。',
            'category_id' => 1,
        ];
        $request = new CreateScript();
        $rules = $request->rules();

        $validator = Validator::make($data, $rules);

        $result = $validator->passes();
        $this->assertFalse($result);
        $expectedFailed = [
            'content' => ['Max' => [100],],
        ];
        $this->assertEquals($expectedFailed, $validator->failed());
    }

    /**
     * カテゴリー未選択の場合はバリデーションエラー
     * @test
     */
    public function script_is_not_available_without_category(): void
    {
        $data = [
            'content' => 'Linuxチョットワカル',
            'category_id' => null,
        ];
        $request = new CreateScript();
        $rules = $request->rules();

        $validator = Validator::make($data, $rules);

        $result = $validator->passes();
        $this->assertFalse($result);
        $expectedFailed = [
            'category_id' => ['Required' => [],],
        ];
        $this->assertEquals($expectedFailed, $validator->failed());
    }

    /**
     * 最後に登録されたカテゴリーを選択の場合は投稿できること
     * @test
     */
    public function script_is_available_with_last_of_category(): void
    {
        $data = [
            'content' => 'Linuxチョットデキル',
            'category_id' => 4,
        ];
        $request = new CreateScript();
        $rules = $request->rules();

        $validator = Validator::make($data, $rules);

        $result = $validator->passes();
        $this->assertTrue($result);
    }

    /**
     * 未登録のカテゴリーIDの場合はバリデーションエラー
     * @test
     */
    public function script_is_not_available_with_not_registrated_category(): void
    {
        $data = [
            'content' => 'Linuxチョットデキル',
            'category_id' => 5,
        ];
        $request = new CreateScript();
        $rules = $request->rules();

        $validator = Validator::make($data, $rules);

        $result = $validator->passes();
        $this->assertFalse($result);
        $expectedFailed = [
            'category_id' => [],
        ];
        $this->assertEquals($expectedFailed, $validator->failed());
    }
}
