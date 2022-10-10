<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Issue;
use App\Models\Ticket;
use App\Models\Worker;
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
    public function get(Request $request, $id = null)
    {
        if ($id == null) {
            $data = response()->json(Ticket::all());
        } else {
            $data = response()->json(Ticket::find($id));
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
            $param  = json_decode($request->all()['param']);
            $customer = json_decode($param->customer, true);
            $ticket = json_decode($param->ticket, true);
            $issues = array_map("self::mapToArray", $param->issues);
            $newCustomer = Customer::create($customer);
            $ticket['customer_id'] = $newCustomer->id;
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
        $param  = (array)json_decode($request->all()['param']);
        if (isset($param['serviced_by'])) {
            $worker = Worker::find($param['serviced_by']);
            $response = $worker->update(
                array(
                    "total_services" => $worker->total_services + 1,
                )
            );
        }

        $ticket = $ticket->update($param);
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
