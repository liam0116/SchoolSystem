<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// 登录路由 - 应用 'throttle:store' 限流器限制尝试次数以防止暴力破解。
Route::post('/sessions', [AuthController::class, 'store'])->middleware('throttle:store');

// 登出路由 - 仅限已认证用户
Route::middleware('auth:sanctum')->delete('/sessions', [AuthController::class, 'destroy']);
