<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use Illuminate\Http\Response;

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
     * @return Response
     */
    public function get($id = null)
    {
        if ($id == null) {
        } else {
            $issues = Issue::query()
                ->where('ticket_id', $id)
                ->get();
        }

        // var_dump($issues);

        return (new Response($issues, 200))
            ->header('Content-Type', 'application/json');
    }
}
