<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
// Requests
use App\Http\Requests\CreateUserRequest;
// Contracts
use App\Contracts\StoreUserServicesInterface;

class UserController extends Controller
{
    protected $userService;

    /**
     * 创建 AuthController 实例。
     *
     * @param StoreUserServiceInterface $userService 用户服务
     */
    public function __construct(StoreUserServicesInterface $userService)
    {
        $this->userService = $userService;
    }

    public function store(CreateUserRequest $request)
    {
        try {
            $isCreated = $this->userService->createUser($request->validated());
            // 检查是否成功创建用户
            if ($isCreated) {
                return response()->json([
                    'success' => true,
                    'msg' => 'User successfully created'
                ], 201); // 201 Created
            } else {
                // 如果创建用户失败，返回一个通用错误响应
                return response()->json([
                    'success' => false,
                    'msg' => 'Failed to create user'
                ], 500); // 500 Internal Server Error
            }
        } catch (\Exception $e) {
            Log::error('User creation failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'msg' => $e->getMessage()
            ], 500);
        }
    }
}
