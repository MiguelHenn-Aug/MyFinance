<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function financeData()
    {
        return response()->json([
            'initial_balance' => 0,
            'entries' => [
                [
                    'date' => date('Y-m-d'),
                    'type' => 'Recebimento',
                    'description' => 'Saldo inicial',
                    'amount' => 0,
                ],
            ],
        ]);
    }
}
