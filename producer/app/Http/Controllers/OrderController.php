<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessOrder;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function order(Request $request)
    {
        $data = [
            'purchase value' => 1000.00,
            'cardNumber' => $request->card_number,
            'cardholderName' => $request->cardholder_name,
            'validDates' => $request->valid_dates,
            'securityCode' => $request->security_code
        ];

        ProcessOrder::dispatch($data)->onConnection('rabbitmq');

        return view('purchase');
    }
}
