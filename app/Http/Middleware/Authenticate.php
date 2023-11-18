<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * 取得使用者未經身份驗證時應重定向到的路徑。
     */
    protected function redirectTo(Request $request): ?string
    {
        // 直接回傳 null，異常處理器 Handler 會處理未認證的情況
        return null;

        // 目前先註解我使用 API 的方式，所以不需要重定向，在Exception/Handler.php中有處理
        // 或回傳一個路由，例如：
        //return $request->expectsJson() ? null : route('login');
    }
}
