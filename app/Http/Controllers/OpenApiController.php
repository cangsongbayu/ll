<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatusEnum;
use App\Helpers\OrderNumberGenerator;
use App\Http\Requests\OpenApi\StoreRequest;
use Illuminate\Support\Facades\DB;
use Throwable;
use App\Models\Order;

class OpenApiController extends Controller
{
    //
    /**
     * @throws Throwable
     */
    public function store(StoreRequest $request)
    {
        return DB::transaction(function() use ($request) {
            $data = $request->validated();
            $order = new Order();
            $order->trade_no = OrderNumberGenerator::generate();
            $order->out_trade_no = $request->input('out_trade_no');
            $order->payment_type_id = $request->paymentType->id;
            $order->merchant_id = $request->merchant->id;
            $order->amount = $request->input('amount');
            $order->status = OrderStatusEnum::FAILED;
        });
    }
}
