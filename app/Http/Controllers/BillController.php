<?php

namespace App\Http\Controllers;

class BillController extends Controller
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
            return 'Returns a list of Bills';
        else
            return 'Returns a single bill of id: ' . $id;
    }
}
