<?php

namespace App\Actions;

use App\Models\CreditCard;

class Posnet
{
    public static function doPayment($tarjeta, $monto, $cuotas)
    {
        if ($cuotas < 1 || $cuotas > 6) {
            throw new \InvalidArgumentException('La cantidad de cuotas debe estar entre 1 y 6.');
        }

        $recargo = ($cuotas > 1) ? ($monto * ($cuotas - 1) * 0.03) : 0;

        $montoTotal = $monto + $recargo;

        $limiteDisponible = $tarjeta->limit;
        if ($montoTotal > $limiteDisponible) {
            throw new \RuntimeException('La tarjeta no tiene límite suficiente para efectuar el pago.');
        }

        $montoCuota = $montoTotal / $cuotas;

        // Generar el ticket
        $ticket = [
            'nombre_cliente' => $tarjeta->holder_first_name . ' ' . $tarjeta->holder_last_name,
            'monto_total' => $montoTotal,
            'monto_cuota' => $montoCuota,
            'cantidad_cuotas' => $cuotas,
        ];

        return $ticket;
    }
}
