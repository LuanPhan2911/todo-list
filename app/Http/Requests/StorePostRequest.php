<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StorePostRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => [
                'bail',
                'required',
                'string',
            ],
            'body' => [
                'bail',
                'required',
            ],
            'user_id' => [
                'bail',
                'required',
                Rule::exists('users', 'id')
            ],
            'category_id' => [
                'required',
                'array',
                Rule::exists(Category::class, 'id'),
            ]

        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(
            [
                'errors' => $validator->errors(),
                'success' => false,
            ],
            400
        ));
    }
}
