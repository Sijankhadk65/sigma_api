<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Response;

class CustomerController extends Controller
{

    /**
     * Retrives a single ticket
     * 
     * @param int $id
     * @return Response
     */
    public function get($id)
    {
        $data = response()->json(Customer::find($id));
        $response = [
            "data" => $data,
        ];
        return (new Response($response, 200))
            ->header('Content-Type', 'application/json');
    }
}
