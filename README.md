# 學校系統筆記(學習開發中)
## 系統版本架構
```bash
Laravel Framework 10.31.0
php ^8.1

架構:
學習使用以下架構原則進行開發
- restful api 规范原則
  - 參考: https://medium.com/itsems-frontend/api-%E6%98%AF%E4%BB%80%E9%BA%BC-restful-api-%E5%8F%88%E6%98%AF%E4%BB%80%E9%BA%BC-a001a85ab638
- HTTP response status codes
  - 參考: https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
- SOLID 原則
- meaning of defining an interface(定義接口含義)
- polymorphism in object-oriented programming(对象编程中的多态性)
- 關連式資料庫設計/資料正規化
  - https://support.microsoft.com/zh-hk/office/%E8%B3%87%E6%96%99%E5%BA%AB%E8%A8%AD%E8%A8%88%E7%9A%84%E5%9F%BA%E6%9C%AC%E6%A6%82%E5%BF%B5-eb2159cf-1e30-401a-8084-bd4f9c9ca1f5 
```
## 系統指令
- git clone 專案過後,安裝相關套件
```
composer install
```
- env 設定
```
1. 安裝 Composer 後，在專案根資料夾中建立 .env 文件，並將 .env.example 文件中的所有內容複製到 .env 檔案中。然後在終端機中執行(切記: 記得 cd 至專案底下)

3. php artisan key:generator 或 php artisan key:gen 指令。
它會在 .env 檔案中為您產生 APP_KEY。

4. 并且設定資料庫:
DB_DATABASE=(本地資料庫名稱)
DB_USERNAME=(xxx)
DB_PASSWORD=(xxx)
```
- 運行遷移，生成設定好的資料表
```
php artisan migrate
```
- 生成模擬數據
  - 運行seeder
```bash
php artisan db:seed
```

- 進行單項測試
  - 沒進行資料清除如果數據庫沒模擬資料必須先執行 php artisan db:seed
  - 注意 php artisan db:seed 會生成模擬數據，於是請在測試環境進行
```bash
php artisan test
```

# 製作過程使用到的指令

## 安裝套件指令

### 安裝 Laravel Sanctum API 令牌:

- Laravel Sanctum 提供了一個輕量級的認證系統，適用於 SPA（單頁應用程式）和簡單的 API 令牌認證。首先，安裝 Sanctum：
```bash
composer require laravel/sanctum
```

- 發布 Sanctum 的設定檔和遷移檔：
```bash
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
```

- 以上指令運行過後檢查設定檔:
  -   檢查您的 Laravel 專案的 config 目錄下是否存在一個名為 sanctum.php 的檔案。這是 Sanctum 的配置文件，如果這個文件存在，表明配置文件已經成功發布。
```bash
/your-project-root-directory/config/sanctum.php
```

- 遷移檔案：
    - 在 Laravel 專案的 database/migrations 目錄下尋找是否有關於 Sanctum 的遷移檔案。這些檔案通常以建立 personal_access_tokens 表的遷移為特徵。如果這個遷移文件存在，表示遷移文件也已經成功發布。
```bash
/your-project-root-directory/database/migrations/xxxx_xx_xx_xxxxxx_create_personal_access_tokens_table.php
```

- 設定令牌有效期
  - 預設情況下，Sanctum 令牌永不過期，並且只能透過撤銷令牌進行無效化。但是，如果你想為你的應用程式 API 令牌配置過期時間，可以透過在應用程式的 sanctum 設定檔中定義的 expiration 設定選項進行設定。此配置選項定義發放的令牌被視為過期之前的分鐘數：
  - config/sanctum.php 設定
```php
  'expiration' => 1440,  // 默認: null
```

- 運行資料庫遷移: 
  - Sanctum 會建立一個資料庫表來儲存 API 令牌:
```bash
php artisan migrate

如果要指定:

php artisan migrate --path=/database/migrations/xxxx_xx_xx_xxxxxx_create_personal_access_tokens_table.php
```

- sanctum 使用到的資料表:
```bash
personal_access_tokens : 這個表用於存儲個人訪問令牌（Personal Access Tokens）。

應用需要標準的 Laravel 數據表
users: 用戶資料表
password_resets: 用於管理用戶密碼重置功能的。當你在 Laravel 應用中啟用內建的密碼重置功能時，這個表將被用於存儲密碼重置令牌和相關信息。
```

# 製作過程修改的東西

- 修改Authenticate以及Handler, 因爲如果 api 請求登出，Authorization 沒帶入 token, 默認情況下會定向至位於 routes 目錄下的 web.php 檔案。如果沒 login 的路由定義，會出現錯誤，沒開APP_DEBUG情況下是500 error
  - app/Middleware/Authenticate.php
  - app/Exceptions/Handler.php
Authenticate.php
```php
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
```
Handler.php
```php
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
```

- 修改app/Providers/AppServiceProvider.php
  - 實現meaning of defining an interface(定義接口含義)綁定
  - 启动任何应用服务限制相同 ip 一分鐘只能訪問5次
```php
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
        $this->app->bind(StoreUserServicesInterface::class,StoreUserServices::class);
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
```