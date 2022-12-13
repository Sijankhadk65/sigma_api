<?php

namespace App\Http\Controllers;

use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
     * Retrives a single transaction
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

    /**
     * Creates a single transaction
     * 
     * @param Request $request
     * @return Response
     */
    public function createTransaction(Request $request)
    {
        $param = $request->all()['param'];
        $transaction = $param['transaction'];
        $newTransaction = response()->json(Transaction::create($transaction));

        $response = [
            "data" => $newTransaction
        ];

        return (new Response($response, 200))
            ->header('Content-type', 'application/json')
            ->header('charset', 'utf-8');
    }

    /**
     * Deletes a single transaction 
     * 
     * @param Request $request
     * @param String $id
     * @return Response
     */
    public function deleteTransaction(Request $request, $id)
    {
        try {
            $status = Transaction::findOrFail($id)->delete();
            return (new Response([
                'status'  => 1,
                'message' => "Delete Successful",
            ], 200))
                ->header('Content-Type', 'application/json');
        } catch (ModelNotFoundException $th) {
            return (new Response([
                'status'  => 0,
                'message' => $th->getMessage(),
            ], 200))
                ->header('Content-Type', 'application/json');
        }
    }
}
