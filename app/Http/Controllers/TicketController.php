<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
     * Creates a single ticket
     * 
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        if ($request->getMethod() == "POST") {
            $ticket = Ticket::create($request->all());
        }
        return (new Response($ticket, 201))
            ->header('Content-Type', 'application/json');
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
        $ticket->update($request->all());

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
        Ticket::findOrFail($id)->delete();
        return (new Response('Deleted Successfully', 200))
            ->header('Content-Type', 'application/json');
    }
}
