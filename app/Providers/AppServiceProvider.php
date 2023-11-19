<?php

namespace App\Providers;
//Illuminate
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;
//Contracts
use App\Contracts\StoreUserServicesInterface;
//Services
use App\Services\StoreUserServices;

class AppServiceProvider extends ServiceProvider
{
    /**
     * 注册任何应用服务。
     * 
     * 在这个方法中，你可以绑定接口和实现类，或者注册服务容器绑定。
     * 这是服务提供者中用于设置依赖注入绑定的地方。
     */
    public function register(): void
    {
        // 在服务提供者中绑定 UserServicesInterface 接口到 UserServices 类的实现
        $this->app->bind(StoreUserServicesInterface::class, StoreUserServices::class);
    }

    /**
     * 启动任何应用服务。
     * 
     * 这个方法在所有服务提供者被注册之后调用，是用来引导任何应用服务的地方。
     * 例如，你可以在这里设置路由、事件监听器、或其他任何需要在请求生命周期开始前准备的功能。
     */
    public function boot(): void
    {
        // 定义了一个名为 'store' 的速率限制器，它限制每个用户名和 IP 地址组合在一分钟内最多尝试 5 次。
        RateLimiter::for('store', function (Request $request) {
            return Limit::perMinute(5)->by($request->input('user_name'). '|' .$request->ip());
        });
    }
}
