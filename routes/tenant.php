<?php

declare(strict_types=1);

use App\Http\Controllers\AuthenticateController;
use App\Http\Controllers\CollectionMethodController;
use App\Http\Controllers\CollectionMethodTypeController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\MerchantBillController;
use App\Http\Controllers\MerchantRateController;
use App\Http\Controllers\PaymentTypeController;
use App\Http\Controllers\SupplierBillController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\SupplierRateController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\MerchantPrepaymentController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\GitController;
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
    Route::get('site-name', 'SiteNameController@get'); // 网站名称
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
        Route::post('/update-project', [GitController::class, 'updateProject'])->name('update.project');
    });

    // 支付方式
    Route::controller(PaymentTypeController::class)->group(function() {
        Route::get('payment-type/all', 'all'); // 所有
        Route::apiResource('payment-type', PaymentTypeController::class); // 资源路由
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
        Route::get('merchant/all', 'all'); // 所有
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

    // 商户费率
    Route::controller(MerchantRateController::class)->group(function() {
        Route::put('merchant-rate/restore/{merchant_rate}', 'restore')->withTrashed(); // 恢复
        Route::put('merchant-rate/batch-restore', 'batchRestore'); // 批量恢复
        Route::delete('merchant-rate/batch-destroy', 'batchDestroy'); // 批量删除
        Route::apiResource('merchant-rate', MerchantRateController::class); // 资源路由
    });

    // 供应商
    Route::controller(SupplierController::class)->group(function() {
        Route::put('supplier/restore/{supplier}', 'restore')->withTrashed(); // 恢复
        Route::put('supplier/batch-restore', 'batchRestore'); // 批量恢复
        Route::delete('supplier/batch-destroy', 'batchDestroy'); // 批量删除
        Route::apiResource('supplier', SupplierController::class);
    });

    // 供应商费率
    Route::controller(SupplierRateController::class)->group(function() {
        Route::put('supplier-rate/restore/{supplier_rate}', 'restore')->withTrashed(); // 恢复
        Route::put('supplier-rate/batch-restore', 'batchRestore'); // 批量恢复
        Route::delete('supplier-rate/batch-destroy', 'batchDestroy'); // 批量删除
        Route::apiResource('supplier-rate', SupplierRateController::class); // 资源路由
    });

    // 押金
    Route::controller(DepositController::class)->group(function() {
        Route::apiResource('deposit', DepositController::class)->only(['index', 'store']); // 资源路由
    });

    // 押金主体列表
    Route::get('depositable/all', 'App\Http\Controllers\DepositableController@all');

    // 收款方式类型
    Route::controller(CollectionMethodTypeController::class)->group(function() {
        Route::apiResource('collection-method-type', CollectionMethodTypeController::class);
    });

    // 收款方式
    Route::controller(CollectionMethodController::class)->group(function() {
        Route::apiResource('collection-method', CollectionMethodController::class);
    });

    // 商户账单
    Route::controller(MerchantBillController::class)->group(function() {
        Route::apiResource('merchant-bill', MerchantBillController::class)->only(['index', 'store']);
    });

    // 供应商账单
    Route::controller(SupplierBillController::class)->group(function() {
        Route::apiResource('supplier-bill', SupplierBillController::class)->only(['index', 'store']);
    });

    // 转账
    Route::controller(TransactionController::class)->group(function() {
        Route::apiResource('transaction', TransactionController::class)->only(['index', 'store']);
    });

    // 设置
    Route::controller(SettingController::class)->group(function() {
        Route::apiResource('setting', SettingController::class)->only(['index']);
    });

    // 文件上传
    Route::controller(UploadController::class)->group(function() {
        Route::post('upload', 'handle');
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

/**
 * 租户系统中供应商用户路由
 */
Route::group([
    'namespace' => 'App\Http\Controllers',
    'middleware' => ['api', InitializeTenancyByRequestData::class],
    'prefix' => 'api/supplier',
], function () {
    Route::post('login', 'AuthenticateController@login'); // 登录
});

Route::group([
    'prefix' => 'api/supplier',
    'middleware' => ['api', InitializeTenancyByRequestData::class, 'auth:supplier']
], function () {
    // 授权模块
    Route::controller(AuthenticateController::class)->group(function() {
        Route::get('me', 'me');
        Route::put('repass', 'repass');
        Route::delete('logout', 'logout');
        Route::get('get-tfa-qrcode', 'getTFAQRCode');
        Route::put('verify-tfa', 'verifyTFA');
        Route::put('verify-tfa', 'verifyTFA');
    });

    // 文件上传
    Route::controller(UploadController::class)->group(function() {
        Route::post('upload', 'handle');
    });
});
