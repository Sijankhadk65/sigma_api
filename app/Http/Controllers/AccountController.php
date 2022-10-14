<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Expense;
use App\Models\Ticket;

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
     * Retrives the expenses accoring to the given filter
     * 
     * @param Request $request 
     * @param int $id
     * @return Response
     */
    public function getExpenses(Request $request, $id = null)
    {
        if ($id == null) {
            $data = response()->json(Expense::all());
        } else {
            $data = response()->json(Expense::find($id));
        }

        $response = [
            "data" => $data,
        ];

        return (new Response($response, 200))
            ->header('Content-Type', 'application/json');
    }

    /**
     * Retrives the credit according to the given filter
     * 
     * @param Request $request 
     * @param int $id
     * @return Response
     */
    public function getCredits(Request $request)
    {

        $data = response()->json(
            Ticket::query()
                ->where('is_payment_due', '=', 0)
                ->get()
        );


        $response = [
            "data" => $data,
        ];

        return (new Response($response, 200))
            ->header('Content-Type', 'application/json');
    }


    /**
     * Create a Expense Item
     */
    public function createExpense(Request $request)
    {
        if ($request->getMethod() == "POST") {
            $param = json_decode($request->all()['param']);
            $expense = json_decode($param->param, true);
            $newExpense = Expense::create($expense);
        }
        return (new Response($newExpense, 200))
            ->header('Content-Type', 'application/json;charset=UTF-8')
            ->header('Charset', 'utf-8');
    }
}
