<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class GitController extends Controller
{
    const WORKING_DIR = '/var/www/ll';

    // 需要用户登录的中间件
    public function __construct()
    {
        $this->middleware('auth');
    }

    // 执行 git pull 和 composer install 的方法
    public function updateProject(Request $request)
    {
        try {
            // git pull
            $gitProcess = new Process(['sudo', 'git', 'pull']);
            $gitProcess->setWorkingDirectory(self::WORKING_DIR);
            $gitProcess->run();

            // 检查 git pull 是否成功
            if (!$gitProcess->isSuccessful()) {
                throw new ProcessFailedException($gitProcess);
            }
            $gitOutput = $gitProcess->getOutput();

            // 判断是否执行 composer install
            if ($request->input('run_composer', false)) {
                $composerProcess = new Process(['sudo', 'composer', 'install']);
                $composerProcess->setWorkingDirectory(self::WORKING_DIR);
                $composerProcess->run();

                // 检查 composer install 是否成功
                if (!$composerProcess->isSuccessful()) {
                    throw new ProcessFailedException($composerProcess);
                }
                $composerOutput = true;
            } else {
                $composerOutput = 'Composer install skipped.';
            }

            // 返回成功信息
            return response()->json([
                'status' => 'success',
                'git_output' => $gitOutput,
                'composer_output' => $composerOutput,
            ], 200);
        } catch (ProcessFailedException $exception) {
            // 返回错误信息
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage(),
            ], 500);
        }
    }
}
