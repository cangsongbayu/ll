<?php

namespace Database\Seeders\Tenant;

use App\Models\Merchant;
use App\Models\MerchantRate;
use App\Models\PaymentType;
use Illuminate\Database\Seeder;

class MerchantRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $paymentTypes = PaymentType::all();
        $merchants = Merchant::all();

        foreach ($paymentTypes as $paymentType) {
            foreach ($merchants as $merchant) {
                $arr = [
                    'payment_type_id' => $paymentType->id,
                    'merchant_id' => $merchant->id,
                    'rate' => '0.5',
                    'is_open_for_business' => 1,
                    'valid_amount' => 100,
                ];
                MerchantRate::create($arr);
            }
        }
    }
}
