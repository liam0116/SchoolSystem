<?php
namespace App\Services;

use App\Contracts\UserServicesInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

/**
 * UserServices 类提供了一系列与用户管理相关的服务。
 *
 * 此类实现了 UserServicesInterface 接口，定义了与用户相关的核心业务逻辑。
 * 它包含了用户数据的检索、密码验证，以及为用户创建认证令牌的方法。
 * 主要用于处理与用户账户相关的操作，如登录验证、用户查找和令牌生成等。
 *
 * 方法包括：
 * - findByUsername($username)：根据用户名查找并返回用户实体。
 * - checkPassword($user, $password)：验证给定用户的密码是否正确。
 * - createTokenForUser($user)：为用户创建并返回一个新的认证令牌。
 *
 * 这个类是用户认证和管理功能的关键组成部分，通常在用户登录流程和令牌管理中使用。
 */
class UserServices implements UserServicesInterface
{
    /**
     * {@inheritdoc}
     */
    public function findByUsername($username)
    {
        return User::where('user_name', $username)->first();
    }

    /**
     * {@inheritdoc}
     */
    public function checkPassword($user, $password)
    {
        return Hash::check($password, $user->password);
    }

    /**
     * {@inheritdoc}
     */
    public function createTokenForUser($user)
    {
        return $user->createToken('auth_token')->plainTextToken;
    }
}