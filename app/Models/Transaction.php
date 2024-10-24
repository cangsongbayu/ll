<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Enums\BillTypeEnum;
use App\Helpers\OrderNumberGenerator;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Transaction
 *
 * @property int $id
 * @property string $trade_no
 * @property int $payer_id
 * @property int $payee_id
 * @property float $amount
 * @property string|null $note
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Transaction extends BaseModel
{
	protected $casts = [
		// 'payer_id' => 'int',
		// 'payee_id' => 'int',
		// 'amount' => 'float',
	];

	protected $fillable = [
		'trade_no',
		'payer_id',
		'payee_id',
		'amount',
		'note'
	];

    public function payer(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'payer_id');
    }

    public function payee(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'payee_id');
    }

    public function createBills(): void
    {
        $currencyId = Currency::where('is_base_currency', true)->value('id');
        $arr = [
            'currency_id' => $currencyId,
            'exchange_rate' => 1,
        ];
        $payerArr = [
            'supplier_id' => $this->payer_id,
            'amount' => bcmul($this->amount, -1, 6),
            'type' => BillTypeEnum::TRANSFER_OUT,
            'base_currency_id' => $currencyId,
            'base_amount' => bcmul($this->amount, -1, 6),
        ];
        $payeeArr = [
            'supplier_id' => $this->payee_id,
            'amount' => $this->amount,
            'type' => BillTypeEnum::TRANSFER_IN,
            'base_currency_id' => $currencyId,
            'base_amount' => $this->amount,
        ];
        SupplierBill::create(array_merge($arr, $payerArr));
        SupplierBill::create(array_merge($arr, $payeeArr));
    }
}
