<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateUserRequest extends FormRequest
{
    /**
     * 确定用户是否有权发起此请求。
     *
     * @return bool 如果用户被授权执行此请求，则返回 true；否则返回 false。
     */
    public function authorize(): bool
    {
        $user = auth()->user();
       
        // 检查用户是否已认证且身份为“行政人员”或“技术人员”
        return $user && in_array($user->identity, ['administrative_staff', 'technical_staff']) && in_array($user->role_enum,['Admin','Staff']);
    }

    /**
     * 获取适用于请求的验证规则。
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'department' => 'required|string|max:255|exists:departments,name',
            'role_enum' => 'required|string|in:Admin,Staff,Professor,Assistant,Student',
            'identity' => 'required|string|in:foreign_student,overseas_student,local_student,exchange_student,professor,associate_professor,assistant_professor,lecturer,research_assistant,visiting_scholar,administrative_staff,technical_staff,librarian,temporary_worker,volunteer,intern',
            'id_card' => 'required|string|max:60',
            'passport' => 'required|string|max:60|regex:/^[A-Z0-9]{5,10}$/',
            'country' => 'required|string|max:50',
            'city' => 'required|string|max:50',
            'address' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:255|regex:/^\+\d{1,3}\d{1,14}(?:x.+)?$/',
            'date_of_birth' => 'required|date',
            'joining_year' => 'required|digits:4'
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

    /**
     * 处理用户未授权的情况。
     *
     * 当 `authorize` 方法返回 false，即用户没有权限执行此请求时，
     * 将调用此方法。此方法创建一个表示用户未授权的 JSON 响应，
     * 并抛出一个 HttpResponseException，中断请求，并返回自定义的错误响应。
     */
    protected function failedAuthorization()
    {   
        $response = response()->json([
            'success' => false,
            'msg' => 'You do not have permission to perform this action.'
        ], 403);

        throw new HttpResponseException($response);
    }
}
