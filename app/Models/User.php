<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

    // 指定自定义主键，不使用 Laravel 的默认主键名 'id'
    protected $primaryKey = 'user_id';

    // 开启自动递增
    public $incrementing = true;

    // 指定主键的类型
    protected $keyType = 'int';

    /**
     * 可批量赋值的属性。
     *
     * 这些是可以使用 Eloquent 的 create 方法或其他批量赋值方法进行赋值的字段。
     * 这些字段对应于数据库迁移中您定义的列。
     */
    protected $fillable = [
        'user_name', 'password', 'role_id', 'department_id', 'name', 'email', 
        'phone_number', 'date_of_birth', 'joining_year', 'identity', 
        'id_card', 'passport', 'country', 'city', 'address'
    ];

    /**
     * 应该被隐藏的属性。
     *
     * 这里的字段不会被包含在模型的数组或 JSON 表示中，这对于敏感信息（如密码）特别有用。
     */
    protected $hidden = [
        'password'
    ];

}
