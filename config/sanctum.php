<?php

use Laravel\Sanctum\Sanctum;

return [

    /*
    |--------------------------------------------------------------------------
    | Stateful Domains（状态保持域名）
    |--------------------------------------------------------------------------
    |
    | 以下域名/主机的请求将接收到保持状态的 API 认证 cookies。通常，这些应包括你的
    | 本地和生产环境域名，这些域名通过前端单页应用程序（SPA）访问你的 API。
    |
    */

    'stateful' => explode(',', env('SANCTUM_STATEFUL_DOMAINS', sprintf(
        '%s%s',
        'localhost,localhost:3000,127.0.0.1,127.0.0.1:8000,::1',
        Sanctum::currentApplicationUrlWithPort()
    ))),

    /*
    |--------------------------------------------------------------------------
    | Sanctum Guards（Sanctum 守卫）
    |--------------------------------------------------------------------------
    |
    | 该数组包含在尝试认证请求时将会检查的认证守卫。如果这些守卫都无法认证请求，
    | Sanctum 将使用传入请求上的 bearer 令牌进行认证。
    |
    */

    'guard' => ['web'],

    /*
    |--------------------------------------------------------------------------
    | Expiration Minutes（过期分钟数）
    |--------------------------------------------------------------------------
    |
    | 此值控制发放的令牌被认为过期前的分钟数。这将覆盖令牌的 "expires_at" 属性中设置的任何值，
    | 但第一方会话不受影响。
    |
    */

    'expiration' => 1440, //null,

    /*
    |--------------------------------------------------------------------------
    | Token Prefix（令牌前缀）
    |--------------------------------------------------------------------------
    |
    | Sanctum 可以为新令牌添加前缀，以利用开源平台维护的众多安全扫描计划，
    | 这些计划通知开发者如果他们将令牌提交到代码仓库中。
    |
    | 参见：https://docs.github.com/en/code-security/secret-scanning/about-secret-scanning
    |
    */

    'token_prefix' => env('SANCTUM_TOKEN_PREFIX', ''),

    /*
    |--------------------------------------------------------------------------
    | Sanctum Middleware（Sanctum 中间件）
    |--------------------------------------------------------------------------
    |
    | 在使用 Sanctum 认证你的第一方单页应用程序（SPA）时，你可能需要自定义 Sanctum 在处理请求时使用的一些中间件。
    | 你可以根据需要更改下面列出的中间件。
    |
    */

    'middleware' => [
        'authenticate_session' => Laravel\Sanctum\Http\Middleware\AuthenticateSession::class,
        'encrypt_cookies' => App\Http\Middleware\EncryptCookies::class,
        'verify_csrf_token' => App\Http\Middleware\VerifyCsrfToken::class,
    ],

];
