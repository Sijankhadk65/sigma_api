<?php

namespace App\Http\Controllers;

class IssueController extends Controller
{

    /**
     * Retrives a single ticket
     * 
     * @param int $id
     * @return Response
     */
    public function get($id = null)
    {
        if ($id == null)
            return 'Returns a list of issues';
        else
            return 'Returns a single issue of id: ' . $id;
    }
}
