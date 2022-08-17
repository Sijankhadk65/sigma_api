<?php

namespace App\Http\Controllers;

class CustomerController extends Controller
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
            return 'Returns a list of customers';
        else
            return 'Returns a single customer of id: ' . $id;
    }
}
