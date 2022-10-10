<?php

namespace App\Http\Controllers;

class ServiceCenterController extends Controller
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
            return 'Returns a list of Service Centers';
        else
            return 'Returns a single Service Center of id: ' . $id;
    }
}
