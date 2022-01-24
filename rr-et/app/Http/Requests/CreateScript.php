<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Category;
use Illuminate\Validation\Rule;

class CreateScript extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $invaild_category_id = Category::getAllCategoryId();
        $category_id_rule = Rule::in($invaild_category_id);
        return [
            'category_id' => 'required|' . $category_id_rule,
            'content' => 'required|max:100',
            'script_img' => 'nullable|image|file|mimes:jpg,png,gif,jpeg|max:5120'
        ];
    }
}
