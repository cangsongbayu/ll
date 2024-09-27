<?php

declare(strict_types=1);

use App\Http\Controllers\AuthenticateController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\MerchantPrepaymentController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\InitializeTenancyByRequestData;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

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

/**
 * 租户路由
 */
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

    // 货币
    Route::controller(CurrencyController::class)->group(function() {
        Route::get('currency/all', 'all'); // 所有
        Route::apiResource('currency', CurrencyController::class); // 资源路由
    });

    // 用户
    Route::controller(UserController::class)->group(function() {
        Route::put('user/restore/{user}', 'restore')->withTrashed(); // 恢复
        Route::put('user/batch-restore', 'batchRestore'); // 批量恢复
        Route::delete('user/batch-destroy', 'batchDestroy'); // 批量删除
        Route::apiResource('user', UserController::class); // 资源路由
    });

    // 代理
    Route::controller(AgentController::class)->group(function() {
        Route::put('agent/restore/{agent}', 'restore')->withTrashed(); // 恢复
        Route::put('agent/batch-restore', 'batchRestore'); // 批量恢复
        Route::delete('agent/batch-destroy', 'batchDestroy'); // 批量删除
        Route::apiResource('agent', AgentController::class); // 资源路由
    });

    // 商户
    Route::controller(MerchantController::class)->group(function() {
        Route::get('merchant/all', 'all'); // 所有
        Route::put('merchant/restore/{merchant}', 'restore')->withTrashed(); // 恢复
        Route::put('merchant/batch-restore', 'batchRestore'); // 批量恢复
        Route::delete('merchant/batch-destroy', 'batchDestroy'); // 批量删除
        Route::apiResource('merchant', MerchantController::class); // 资源路由
    });

    // 商户预付
    Route::controller(MerchantPrepaymentController::class)->group(function() {
        Route::apiResource('merchant-prepayment', MerchantPrepaymentController::class)->only(['index', 'store']); // 资源路由
    });

    // 押金
    Route::controller(DepositController::class)->group(function() {
        Route::apiResource('deposit', DepositController::class)->only(['index', 'store']);
    });

    // 设置
    Route::controller(SettingController::class)->group(function() {
        Route::apiResource('setting', SettingController::class)->only(['index']);
    });
});

/**
 * 租户系统中代理用户路由
 */
Route::group([
    'namespace' => 'App\Http\Controllers',
    'middleware' => ['api', InitializeTenancyByRequestData::class],
    'prefix' => 'api/agent',
], function () {
    Route::post('login', 'AuthenticateController@login'); // 登录
});

Route::group([
    'prefix' => 'api/agent',
    'middleware' => ['api', InitializeTenancyByRequestData::class, 'auth:agent']
], function () {
    // 授权模块
    Route::controller(AuthenticateController::class)->group(function() {
        Route::get('me', 'me');
        Route::put('repass', 'repass');
        Route::delete('logout', 'logout');
        Route::get('get-tfa-qrcode', 'getTFAQRCode');
        Route::put('verify-tfa', 'verifyTFA');
    });
});

/**
 * 租户系统中商户用户路由
 */
Route::group([
    'namespace' => 'App\Http\Controllers',
    'middleware' => ['api', InitializeTenancyByRequestData::class],
    'prefix' => 'api/merchant',
], function () {
    Route::post('login', 'AuthenticateController@login'); // 登录
});

Route::group([
    'prefix' => 'api/merchant',
    'middleware' => ['api', InitializeTenancyByRequestData::class, 'auth:merchant']
], function () {
    // 授权模块
    Route::controller(AuthenticateController::class)->group(function() {
        Route::get('me', 'me');
        Route::put('repass', 'repass');
        Route::delete('logout', 'logout');
        Route::get('get-tfa-qrcode', 'getTFAQRCode');
        Route::put('verify-tfa', 'verifyTFA');
    });
});
