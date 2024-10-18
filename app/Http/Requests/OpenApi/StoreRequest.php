<?php

namespace App\Http\Requests\OpenApi;

use App\Helpers\Amount;
use App\Http\Requests\FormRequest;
use App\Models\Merchant;
use App\Models\MerchantRate;
use App\Models\PaymentType;
use Illuminate\Contracts\Validation\ValidationRule;

class StoreRequest extends FormRequest
{
    public Merchant|null $merchant;
    public PaymentType|null $paymentType;
    public MerchantRate|null $merchantRate;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            //
            'appid' => [
                'bail',
                'required',
                'exists:App\Models\Merchant,appid,deleted_at,NULL',
                function ($attr, $value, $fail) {
                    $this->merchant = Merchant::where('appid', $value)->first();
                    if (is_null($this->merchant)) {
                        return $fail('商户号 不存在。');
                    }
                    if (!$this->merchant->is_open_for_business) {
                        return $fail('营业 未开启。');
                    }
                    return true;
                }
            ],
            'code' => [
                'bail',
                'required',
                function ($attr, $value, $fail) {
                    $this->paymentType = PaymentType::where('code', $value)->first();
                    if (is_null($this->paymentType)) {
                        return $fail('编码 不存在。');
                    }
                    $errors = $this->validator->errors();
                    if ($errors->hasAny('appid')) {
                        // 跳过检查
                        return true;
                    }
                    // 检查费率
                    $this->merchantRate = MerchantRate::where('merchant_id', $this->merchant->id)->where('payment_type_id', $this->paymentType->id)->first();
                    if (is_null($this->merchantRate)) {
                        return $fail("费率 未配置【{$this->paymentType->name}】。");
                    }
                    if (!$this->merchantRate->is_open_for_business) {
                        return $fail('费率 未开启。');
                    }
                    return true;
                }
            ],
            'amount' => [
                'bail',
                'required',
                'decimal:0,2',
                function ($attr, $value, $fail) {
                    $errors = $this->validator->errors();
                    if ($errors->hasAny('appid', 'code')) {
                        // 跳过检查
                        return true;
                    }
                    if (!Amount::isValid($this->merchantRate->valid_amount, $value)) {
                        return $fail("金额 无效，有效金额为：{$this->merchantRate->valid_amount}");
                    }
                    return true;
                }
            ],
            'out_trade_no' => [
                'bail',
                'required',
                'string',
                'max:255',
            ],
        ];
    }
}
