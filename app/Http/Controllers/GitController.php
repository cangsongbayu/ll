<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Process;
use App\Helpers\ApiResponse;
use App\Enums\ApiMessageEnum;
use App\Enums\ApiMessageShowTypeEnum;
use App\Enums\ApiErrorCodeEnum;


class GitController extends Controller
{
    
    // 需要用户登录的中间件
    public function __construct()
    {
        $this->middleware('auth');
    }

    // 执行 git pull 和 composer install 的方法
    public function updateProject(Request $request)
    {
        // 获取工作目录配置
        $workingDir = base_path();
        try {
            //git pull
            $gitProcess = Process::path($workingDir)->run(['sudo', 'git', 'pull']);

            // 检查 git pull 是否成功
            if ($gitProcess->failed()) {
                throw new \Exception('Git pull failed: ' . $gitProcess->errorOutput());
            }

            $gitOutput = $gitProcess->output();

            // 判断是否需要执行 composer install
            if ($request->input('run_composer') === true) {
                //composer install
                $composerProcess = Process::path($workingDir)->run(['sudo', 'composer', 'install']);

                // 检查 composer install 是否成功
                if ($composerProcess->failed()) {
                    throw new \Exception('Composer install failed: ' . $composerProcess->errorOutput());
                }

                $composerOutput = 'Composer install executed successfully.';
            } else {
                $composerOutput = 'Composer install not executed.';
            }

            // 返回成功信息
            return ApiResponse::success(
                [
                    'status' => 'success',
                    'git_output' => $gitOutput,
                    'composer_output' => $composerOutput,
                ],
                ApiMessageEnum::STORE_OR_UPDATE->getMessage(),
                ApiMessageShowTypeEnum::SUCCESS,
            );

        } catch (\Exception $exception) {
            // 返回错误信息
            return ApiResponse::fail(
                $exception->getMessage(),
                ApiErrorCodeEnum::METHOD_NOT_ALLOWED_HTTP_EXCEPTION,
            );
        }
    }
}
