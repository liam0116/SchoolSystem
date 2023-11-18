<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colleges extends Model
{
    use HasFactory;

     // 指定表名（可选，如果表名符合 Laravel 命名规则）
     protected $table = 'colleges';

     // 指定自定义主键，不使用 Laravel 的默认主键名 'id'
     protected $primaryKey = 'college_id';
 
     // 开启自动递增
     public $incrementing = true;
  
     // 指定主键的类型
     protected $keyType = 'int';
 
     // 定义可被批量赋值的属性
     protected $fillable = ['college_id', 'name'];
 
     public $timestamps = false;  // 禁用时间戳
}
