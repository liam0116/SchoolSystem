<?php

namespace App\Http\Controllers;

use App\Contracts\UserServicesInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    protected $userService;

    /**
     * 创建 AuthController 实例。
     *
     * @param UserServiceInterface $userService 用户服务
     */
    public function __construct(UserServicesInterface $userService)
    {
        $this->userService = $userService;
    }

    /**
     * 處理用戶登錄請求。
     *
     * @param Request $request HTTP 請求
     * @return \Illuminate\Http\JsonResponse JSON 數據
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        // 验证請求參數
        $validator = Validator::make($request->all(), [
            'user_name' => 'required|string',
            'password' => 'required|string',
        ]);

        // 验证失败, 返回 422 状态码和第一个错误信息
        if ($validator->fails()) {
            $firstErrorMessage = $validator->errors()->first();
            return response()->json([
                'success' => false,
                'msg' => $firstErrorMessage
            ], 422);
        }

        $username = $request->input('user_name');
        $password = $request->input('password');

        try {
            // 使用 UserService 尋找用戶
            $user = $this->userService->findByUsername($username);

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'msg' => 'User not found.'
                ], 404);
            }

            // 檢查密碼是否正確
            if (!$this->userService->checkPassword($user, $password)) {
                return response()->json([
                    'success' => false,
                    'msg' => 'Incorrect password.'
                ], 401);
            }

            // 成功登錄，建立新的令牌
            $token = $this->userService->createTokenForUser($user);

        } catch (\Exception $e) {

            Log::error('Login error in findByUsername: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'msg' => 'An error occurred while attempting to login.'
            ], 500);
        }
        return response()->json([
            'success' => true,
            'msg' => 'Login successful',
            'token' => $token
        ], 200);
    }

    /**
     * 处理用户登出请求。
     *
     * 此方法用于处理 API 用户的登出操作。它会删除用户当前的访问令牌，
     * 从而结束用户的会话并使其失效。
     *
     * @param Request $request 当前 HTTP 请求实例
     * @return \Illuminate\Http\JsonResponse 返回登出操作的响应
     */
    public function destroy(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = $request->user();

        // 刪除令牌，處理可能的失敗
        try {
            $user->currentAccessToken()->delete();
        } catch (\Exception $e) {

            Log::error('Error Logout failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'msg' => 'Logout process encountered an unexpected error.'
            ], 500);
        }

        return response()->json([
            'success' => true,
            'msg' => 'Logout successful'
        ], 200);
    }
}
