<?php

namespace App\Services;

use App\Enums\ActivityLogEventEnum;
use App\Enums\ActivityLogNameEnum;
use App\Enums\LoginFailedReasonEnum;
use App\Exceptions\LoginFailedException;
use App\Helpers\Agent;
use App\Http\Requests\Authenticate\LoginRequest;
use App\Helpers\IP;
use App\Http\Requests\Authenticate\RepassRequest;
use App\Http\Requests\Authenticate\VerifyTFARequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\PersonalAccessToken;
use Throwable;

class AuthenticateService
{
    /**
     * @throws LoginFailedException
     * @throws Throwable
     */
    public function login(LoginRequest $request): array
    {
        return DB::transaction(function() use ($request) {
            // 登录用户的模型类名
            $authenticateModelClass = config("auth.providers.{$request->login_type}.model");
            // 登录名称
            $loginName = config("auth.providers.{$request->login_type}.login_name");
            // 日志信息
            $log = Agent::getAgentInfo(['login_name' => $request->$loginName]);

            // 验证用户名是否存在
            $user = $authenticateModelClass::where($loginName, $request->$loginName)->first();

            if (is_null($user)) {
                throw new LoginFailedException(
                    ActivityLogEventEnum::getLoginFailureDescription(LoginFailedReasonEnum::USERNAME_NOT_FOUND->value),
                    0,
                    $log,
                );
            }

            // 验证密码是否正确
            if (!Hash::check($request->password, $user->password)) {
                throw new LoginFailedException(
                    ActivityLogEventEnum::getLoginFailureDescription(LoginFailedReasonEnum::PASSWORD_INCORRECT->value),
                    0,
                    $log,
                );
            }

            // 验证是否启用 2FA
            if ($user->is_enable_tfa) {
                $google2fa = app('pragmarx.google2fa');
                if (!$request->has('tfa_code') || !$google2fa->verifyKey($user->tfa_secret, $request->tfa_code)) {
                    throw new LoginFailedException(
                        ActivityLogEventEnum::getLoginFailureDescription(LoginFailedReasonEnum::TFA_CODE_INCORRECT->value),
                        0,
                        $log,
                    );
                }
            }

            // 设置当前登录用户
            auth()->setUser($user);
            // 创建令牌
            $token = $user->createToken($user->$loginName, [], now()->addMinutes(config('sanctum.expiration')));
            // 删除多余令牌
            $user->deleteExcessTokens();
            // 记录登录日志
            $this->inActivityLog($log);
            // 返回令牌
            return [
                'token' => $token->plainTextToken,
            ];
        });
    }

    public function me(Request $request): array
    {
        $user = $request->user();
        return [
            'name' => $user->name,
            'avatar' => 'https://gw.alipayobjects.com/zos/antfincdn/XAosXuNZyF/BiazfanxmamNRoxxVxka.png',
        ];
    }

    /**
     * @throws Throwable
     */
    public function repass(RepassRequest $request)
    {
        return DB::transaction(function() use ($request) {
            $user = $request->user();
            $user->password = $request->password;
            $user->save();
            $user::deleteTokens($user->id);
            return $user;
        });
    }

    /**
     * @throws Throwable
     */
    public function logout(Request $request)
    {
        return DB::transaction(function() use ($request) {
            // 日志信息
            $log = Agent::getAgentInfo();
            // 记录退出日志
            $this->inActivityLog($log, ActivityLogEventEnum::LOGOUT);
            $token = $request->user()->currentAccessToken();
            if ($token instanceof PersonalAccessToken) {
                $token->delete();
            }
        });
    }

    /**
     * @throws Throwable
     */
    public function getTFAQRCode(Request $request): array
    {
        return DB::transaction(function() use ($request) {
            $user = $request->user();
            $google2fa = app('pragmarx.google2fa');
            $user->tfa_secret = $google2fa->generateSecretKey();
            $user->save();
            $appName = config('app.name');
            return [
                'qr' => $google2fa->getQRCodeUrl($appName, $user->name, $user->tfa_secret),
            ];
        });
    }

    /**
     * @throws Throwable
     */
    public function verifyTFA(VerifyTFARequest $request)
    {
        return DB::transaction(function() use ($request) {
            $user = $request->user();
            $user->is_enable_tfa = !$user->is_enable_tfa;
            $user->save();
            return $user;
        });
    }

    /**
     * 记录日志
     * @param $properties
     * @param ActivityLogEventEnum $activityLogEventEnum
     * @return void
     */
    public function inActivityLog($properties, ActivityLogEventEnum $activityLogEventEnum = ActivityLogEventEnum::LOGIN_SUCCESS): void
    {
        $log = activity()->performedOn(auth()->user())->withProperties($properties);

        if ($activityLogEventEnum === ActivityLogEventEnum::LOGIN_SUCCESS) {
            $log->inLog(ActivityLogNameEnum::LOGIN->value)
                ->event(ActivityLogEventEnum::LOGIN_SUCCESS->value)
                ->log(ActivityLogEventEnum::LOGIN_SUCCESS->getActivityLogDescription());
        } else if ($activityLogEventEnum === ActivityLogEventEnum::LOGOUT) {
            $log->inLog(ActivityLogNameEnum::LOGIN->value)
                ->event(ActivityLogEventEnum::LOGOUT->value)
                ->log(ActivityLogEventEnum::LOGOUT->getActivityLogDescription());
        }
    }
}
