<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\InitializeTenancyByRequestData;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthenticateController;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::get('/', function () {
        return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
    });
});

Route::group([
    'namespace' => 'App\Http\Controllers',
    'middleware' => ['api', InitializeTenancyByRequestData::class],
    'prefix' => 'api/tenant',
], function () {
    Route::post('login', 'AuthenticateController@login'); // 登录
});

Route::group([
    'prefix' => 'api/tenant',
    'middleware' => ['api', InitializeTenancyByRequestData::class, 'auth:tenant']
], function() {
    // 授权模块
    Route::controller(AuthenticateController::class)->group(function() {
        Route::get('me', 'me');
        Route::put('repass', 'repass');
        Route::delete('logout', 'logout');
        Route::get('get-tfa-qrcode', 'getTFAQRCode');
        Route::put('verify-tfa', 'verifyTFA');
    });

    // 用户模块
    Route::controller(UserController::class)->group(function() {
        Route::put('user/restore/{user}', 'restore')->withTrashed(); // 恢复
        Route::put('user/batch-restore', 'batchRestore'); // 批量恢复
        Route::delete('user/batch-destroy', 'batchDestroy'); // 批量删除
        Route::apiResource('user', UserController::class); // 资源路由
    });
});
