# 學校系統筆記
## 系統指令
- 生成模擬數據
  - 運行seeder
```bash
php artisan db:seed
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