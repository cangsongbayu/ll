<?php

use Illuminate\Encryption\Encrypter;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/test', function () {
    $passwordKey = config('app.password_key');
    // 移除 "base64:" 前缀（如果存在）
    if (str_starts_with($passwordKey, 'base64:')) {
        $passwordKey = substr($passwordKey, 7);
    }
    $encrypter = new Encrypter(base64_decode($passwordKey), 'AES-256-CBC');
    echo $encrypter->encrypt('123');
});
