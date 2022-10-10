<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class IssueController extends Controller
{

    private $db;

    /**
     * Instantiate new IssueController instance
     * 
     * @return void
     */
    public function __construct()
    {
        $this->db = app('db');
    }

    /**
     * Retrives a single ticket
     * 
     * @param int $id
     * @param Request $request
     * @return Response
     */
    public function get(Request $request, $id = null)
    {
        if ($id == null) {
            $issues = [];
        } else {
            $issues = response()->json(Issue::query()
                ->where('ticket_id', '=', $id)
                ->get());
        }

        $response = [
            'data' => $issues,
        ];

        return (new Response($response, 200))
            ->header('Content-Type', 'application/json');
    }
}
