<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Transaction;

class AccountController extends Controller
{
    /**
     * Instantiate new TicketController instance.
     * 
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Retrives a single ticket
     * 
     * @param int $id
     * @param Request $request
     * @return Response
     */
    public function getTransactions(Request $request, $id = null)
    {
        if ($id == null) {
            $transaction = response()->json(Transaction::all());
        } else {
            $transaction = response()->json(Transaction::findOrFail($id));
        }

        $response = [
            'data' => $transaction,
        ];

        return (new Response($response, 200))
            ->header('Content-Type', 'application/json');
    }
}
