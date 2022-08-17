<?php

namespace App\Http\Controllers;

class ServicerController extends Controller
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
            return 'Returns a list of servicers';
        else
            return 'Returns a single servicer of id: ' . $id;
    }
}
