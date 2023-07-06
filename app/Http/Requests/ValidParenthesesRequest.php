<?php

namespace App\Http\Requests;

use App\Http\Traits\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class ValidParenthesesRequest extends FormRequest
{
    use ApiResponse {
        error as validatorError;
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            's' => 'required|string|min:1|max:10000|regex:/^[\(\)\[\]\{\}]+$/',
        ];
    }

    public function messages(): array
    {
        return [
            's.regex' => '参数 s 只允许包含()[]{}这些字符中的一个或多个！',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $this->validatorError($validator->errors()->first(), Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
