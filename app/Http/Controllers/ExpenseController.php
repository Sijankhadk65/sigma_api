<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Ticket;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ExpenseController extends Controller
{

    /**
     * Retrives a single ticket
     * 
     * @param int $id
     * @return Response
     */
    public function get(Request $request, $id = NULL)
    {
        if ($id != NULL) {
            $data = response()->json(
                Expense::query()
                    ->where('ticket_id', '=', 'id')
                    ->get()
            );
        }

        $data = response()->json(Expense::all());

        $response = [
            "data" => $data
        ];

        return (new Response($response, 200))
            ->header('Content-type', 'application/json')
            ->header('Charset', 'utf-8');
    }

    /**
     * Creates an element of the Expense Model
     * 
     * @param Request $request
     * @return Response $response
     */
    public function create(Request $request)
    {
        $param = $request->all()['param'];
        $expense = $param['expense'];
        $newExpense = response()->json(Expense::create($expense));

        $response = [
            "data" => $newExpense
        ];

        return (new Response($response, 200))
            ->header('Content-Type', 'application/json')
            ->header('Charset', 'utf-8');
    }




    /**
     * Deletes an element of the Expense model
     * 
     * @param Request $request
     * @param String $id
     * 
     * @return Response 
     */
    public function delete(Request $request, $id)
    {
        try {
            $status = Expense::findOrFail($id)->delete();
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
