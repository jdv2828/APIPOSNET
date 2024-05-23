<?php

namespace App\Http\Controllers;

use App\Models\CreditCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CreditCardController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bank_name' => 'required|string|max:255',
            'card_number' => 'required|string|size:8|unique:credit_cards,card_number',
            'card_type' => 'required|in:Visa,AMEX',
            'limit' => 'required|numeric|min:0',
            'holder_dni' => 'required|string|max:255',
            'holder_first_name' => 'required|string|max:255',
            'holder_last_name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $creditCard = CreditCard::create($request->all());

        return response()->json($creditCard, 201);
    }
}
