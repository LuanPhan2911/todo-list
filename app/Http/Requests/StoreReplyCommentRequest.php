<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreReplyCommentRequest extends FormRequest
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
            'message' => [
                'required',
                'string',
                'bail',
            ],
            'user_id' => [
                'bail',
                'required',
                Rule::exists('users', 'id')
            ],
            'post_id' => [
                'required',
                'bail',
                Rule::exists('posts', 'id')
            ],
            'parent_id' => [
                'required',
                Rule::exists('comments', 'id')
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
