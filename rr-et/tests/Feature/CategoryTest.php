<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Category;
use Illuminate\Support\Carbon;
use App\Http\Requests\CreateCategory;
use Illuminate\Support\Facades\Validator;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed('CategoriesTableSeeder');
    }

    /**
     * カテゴリ名が空欄の場合はバリデーションエラー
     * @test
     */
    public function name_is_not_available_in_0_charactors(): void
    {
        $data = [
            'name' => '',
        ];
        $request = new CreateCategory();
        $rules = $request->rules();

        $validator = Validator::make($data, $rules);

        $result = $validator->passes();
        $this->assertFalse($result);
        $expectedFailed = [
            'name' => ['Required' => [],],
        ];
        $this->assertEquals($expectedFailed, $validator->failed());
    }

    /**
     * カテゴリ名が１文字の場合は登録可能
     * @test
     */
    public function name_is_available_in_1_charactor(): void
    {
        $data = [
            'name' => 'X',
        ];
        $request = new CreateCategory();
        $rules = $request->rules();

        $validator = Validator::make($data, $rules);

        $result = $validator->passes();
        $this->assertTrue($result);
    }

    /**
     * カテゴリ名が３０文字の場合は登録可能
     * @test
     */
    public function name_is_available_in_30_charactors(): void
    {
        $data = [
            'name' => 'organic agriculture in myanmar',
        ];
        $request = new CreateCategory();
        $rules = $request->rules();

        $validator = Validator::make($data, $rules);

        $result = $validator->passes();
        $this->assertTrue($result);
    }

    /**
     * カテゴリ名が３１文字の場合はバリデーションエラー
     * @test
     */
    public function name_is_not_available_in_31_charactors(): void
    {
        $data = [
            'name' => 'organic agriculture in myanmar!',
        ];
        $request = new CreateCategory();
        $rules = $request->rules();

        $validator = Validator::make($data, $rules);

        $result = $validator->passes();
        $this->assertFalse($result);
        $expectedFailed = [
            'name' => ['Max' => [30],],
        ];
        $this->assertEquals($expectedFailed, $validator->failed());
    }
}
