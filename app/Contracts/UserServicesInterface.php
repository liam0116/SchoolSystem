<?php
namespace App\Contracts;

/**
 * 用户服务接口定义。
 *
 * 此接口定义了与用户相关的核心业务逻辑，包括用户的查找、密码验证和令牌创建。
 * 它被用于抽象用户相关操作的实现细节，从而使控制器更专注于处理HTTP请求和响应。
 */
interface UserServicesInterface
{
    /**
     * 根据用户名查找用户。
     *
     * @param string $username 用户名
     * @return \App\Models\User|null 用户实例或null
     */
    public function findByUsername($username);

    /**
     * 检查给定的密码是否与用户的密码相匹配。
     *
     * @param \App\Models\User $user 用户实例
     * @param string $password 密码
     * @return bool 密码是否正确
     */
    public function checkPassword($user, $password);

    /**
     * 为用户创建一个新的 API 令牌。
     *
     * @param \App\Models\User $user 用户实例
     * @return string 令牌字符串
     */
    public function createTokenForUser($user);
}