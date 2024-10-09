<?php

namespace App\Http\Requests\Upload;

use App\Enums\UploadFileTypeEnum;
use App\Http\Requests\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rules\Enum;
use Zxing\QrReader;

class HandleRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            //
            'file_type' => [
                'required',
                new Enum(UploadFileTypeEnum::class),
            ],
            'file' => [
                'required',
                'mimes:jpeg,png',
                function ($attr, $value, $fail) {
                    $errors = $this->validator->errors();
                    if (!$this->has('file_type') || $errors->has('file_type')) {
                        // 如果 file_type 未通过验证，则不再验证 file
                        return true;
                    }
                    if ($this->input('file_type') === UploadFileTypeEnum::QR_FILE->value) {
                        // 如果 file_type 类型为 QR 则进行 QR 规则验证
                        $file = $this->file('file');
                        $path = $file->path();
                        $qrcode = new QrReader($path);
                        $text = $qrcode->text();
                        if (!$text) {
                            return $fail('二维码 识别失败。');
                        }
                        $this->merge(['context' => ['qr_text' => $text]]);
                    }
                    return true;
                }
            ],
        ];
    }
}
