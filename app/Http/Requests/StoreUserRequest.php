<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreUserRequest extends FormRequest
{
    /**
     * 确定用户是否有权发起此请求。
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * 获取适用于请求的验证规则。
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_name' => 'required|string|alpha_num|max:30',
            'password' => ['required', 'string', Password::min(8)->mixedCase()->numbers()->symbols()],
        ];
    }

    /**
     * 处理验证失败的情况。
     *
     * 当请求数据不符合定义的验证规则时，将调用此方法。
     * 此方法创建一个包含错误信息的 JSON 响应，并抛出一个 HttpResponseException，
     * 从而阻止请求继续进行，并直接返回错误响应。
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator 验证器实例，包含了验证失败的信息。
     */
    protected function failedValidation(Validator $validator)
    {
        $response = response()->json([
            'success' => false,
            'msg' => $validator->errors()->first(),
        ], 422);

        throw new HttpResponseException($response);
    }
}
