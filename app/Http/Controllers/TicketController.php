<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Customer;
use App\Models\Issue;
use App\Models\Ticket;
use App\Models\Transaction;
use App\Models\Worker;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class TicketController extends Controller
{

    private $db;

    /**
     * Instantiate new TicketController instance.
     * 
     * @return void
     */
    public function __construct()
    {
        // Auth Middleware.
        // $this->middleware('auth');
        $this->db = app('db');
    }

    /**
     * Retrives a single or a list of tickets
     * 
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function get(Request $request, $id = null, $filters = [])
    {
        if ($id != null) {
            $data = response()->json(Ticket::find($id));
        } else if (!$request->filled('filters')) {
            $data = response()->json(Ticket::all());
        } else {
            $filters = $request->input('filters');
            if (in_array("paid", $filters) && in_array("closed", $filters)) {
                $payment = "0";
                $closed = "1";
            } else if (in_array("not paid", $filters) && in_array("open", $filters)) {
                $payment = "1";
                $closed = "0";
            }
            $data = response()->json(
                Ticket::query()
                    ->where("is_payment_due", "=", $payment)
                    ->where("Is_closed", "=", $closed)
                    ->get()
            );
        }

        $response = [
            "data" => $data,
        ];

        return (new Response($response, 200))
            ->header('Content-Type', 'application/json');
    }

    /**
     * Maps an Object to an Array
     * 
     * @param String $item
     * @return Array
     */
    public static function mapToArray($item)
    {
        return json_decode($item, true);
    }

    /**
     * Creates a single ticket
     * 
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        if ($request->getMethod() == "POST") {
            $param  = $request->all()['param'];
            // var_dump($param);
            // exit;
            $ticket = $param['ticket'];
            // echo gettype($param['issues']);
            // exit;
            $issues = $param['issues'];
            $newTicket = Ticket::create($ticket);
            foreach ($issues as $issue) {
                $issue['ticket_id'] = $newTicket->id;
                $newIssue = Issue::create($issue);
            }
        }

        return (new Response($newTicket, 200))
            ->header('Content-Type', 'application/json;charset=UTF-8')
            ->header('Charset', 'utf-8');
    }


    /**
     * Updates a single ticket
     * 
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);
        // $param  = (array)json_decode($request->all()['param']);
        $param  = $request->all()['param'];
        $updateParams = $param;
        if (isset($param['serviced_by'])) {
            $worker = Worker::find($param['serviced_by']);
            $response = $worker->update(
                array(
                    "total_services" => $worker->total_services + 1,
                )
            );
        }

        if (isset($param['is_payment_due']) && isset($param['user'])) {
            $newTransactionArray = array(
                "created_at" => Carbon::now()->toDateTimeString(),
                "created_by" => $param['user'],
                "transaction_at" => Carbon::now()->toDateTimeString(),
                "type" => "credit",
                "soruce" => "service",
                "description" => $ticket->id,
                "amount" => 0,
            );
            $newTransaction = Transaction::create($newTransactionArray);
            var_dump($newTransaction);
            exit;
        }

        if (isset($param['command']) && isset($param['cost'])) {
            if ($param['command'] == "increase") {
                $updateParams = [
                    "total_service_cost" => $ticket->total_service_cost + $param['cost']
                ];
            } elseif ($param['command'] == "decrease") {
                $updateParams = [
                    "total_service_cost" => $ticket->total_service_cost - $param['cost']
                ];
            }
        }

        $ticket = $ticket->update($updateParams);
        $ticket = Ticket::findOrFail($id);
        return (new Response($ticket, 200))
            ->header('Content-Type', 'application/json');
    }

    /**
     * Deletes a single ticket
     * 
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function delete(Request $request, $id)
    {
        try {
            $status = Ticket::findOrFail($id)->delete();
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
