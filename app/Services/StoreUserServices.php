<?php
namespace App\Services;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
//Contracts
use App\Contracts\StoreUserServicesInterface;
//Models
use App\Models\User;
use App\Models\Departments;

/**
 * StoreUserServices 类提供了一系列与用户管理相关的服务。
 *
 * 此类实现了 StoreUserServicesInterface 接口，定义了与用户相关的核心业务逻辑。
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
class StoreUserServices implements StoreUserServicesInterface
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

    /**
     * {@inheritdoc}
     */
    public function createUser(array $data)
    {
        try {
            // 根据部门名称查找部门实例
            $department = Departments::where('name', $data['department'])->first();

            // 如果找不到部门，则可能需要处理错误
            if (!$department) {
                throw new \Exception('Department not found.');
            }

            DB::beginTransaction();

            // 原生 SQL 插入用户数据
            $sql = "INSERT INTO users 
            (user_name, name, email, phone_number, password, department_id, role_enum, identity, id_card, passport, country, city, address, date_of_birth, joining_year, created_at, updated_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            DB::insert($sql, [
                $data['email'], // 自动生成或从请求中获取
                $data['name'],
                $data['email'],
                $data['phone_number'],
                Hash::make($data['date_of_birth']), // 密码加密
                $department->department_id, // 部门ID，需要从部门名称转换获取
                $data['role_enum'],
                $data['identity'],
                $data['id_card'],
                $data['passport'],
                $data['country'],
                $data['city'],
                $data['address'],
                $data['date_of_birth'],
                $data['joining_year'],
                now(), // 当前时间
                now()  // 当前时间
            ]);

            // 获取刚插入记录的 ID
            $insertedUserId = DB::getPdo()->lastInsertId();

            // 构造用户名并更新
            $username = $data['joining_year']. $department->department_id . str_pad($insertedUserId, 5, '0', STR_PAD_LEFT);
            
            $updateSql = "UPDATE users SET user_name = ? WHERE user_id = ?";
            DB::update($updateSql, [$username, $insertedUserId]);

            DB::commit();
            return true; // 操作成功，返回 true
        } catch (QueryException $qe) {
            // 捕获并处理数据库查询异常
            DB::rollBack();
            Log::error('Database query error: ' . $qe->getMessage());
            // 可以选择抛出异常或返回特定的错误响应
            throw new \Exception('Database operation failed.');
        } catch (\Exception $e) {
            // 捕获其他所有异常
            DB::rollBack();
            Log::error('Error in createUser: ' . $e->getMessage());
            throw $e;
        }
    }
}