<?php

namespace App\Http\Controllers;

use App\Actions\Posnet;
use App\Models\CreditCard;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            $datos = $request->validate([
                'tarjeta' => 'required|exists:credit_cards,id',
                'monto' => 'required|numeric|min:0',
                'cuotas' => 'required|integer|min:1|max:6',
            ]);

            $tarjeta = CreditCard::findOrFail($datos['tarjeta']);

            $ticket = Posnet::doPayment(
                $tarjeta,
                $datos['monto'],
                $datos['cuotas']
            );

            return response()->json($ticket, 200);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        } catch (\RuntimeException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
