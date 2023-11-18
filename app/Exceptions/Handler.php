<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{

    /**
     * 当用户未通过身份验证时处理方法。
     *
     * @param \Illuminate\Http\Request $request 当前的 HTTP 请求
     * @param \Illuminate\Auth\AuthenticationException $exception 认证异常
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        // API 請求，格式錯誤反回錯誤信息
        if ($request->expectsJson()) {
            return response()->json(['success' => false, 'msg' => 'Authorization failed, please log in again.'], 401);
        }

        // 如果有 web 前端，并且有定義 login 路由，可以使用保留重定向
        // return redirect()->guest(route('login'));

        // 否則，也可以在這裡回傳一個適當的錯誤訊息
        // 例如，如果您沒有 login 路由，可以傳回一個通用的錯誤訊息
        return response()->json(['success' => false, 'msg' => 'Unauthorized, access denied.'], 401);
    }

    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
