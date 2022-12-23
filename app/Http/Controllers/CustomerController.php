<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class CustomerController extends Controller
{

    /**
     * Retrives a single ticket
     * 
     * @param Request $request
     * @param String $id     * 
     * 
     * @return Response
     */
    public function get(Request $request, $id = null, $searchTerm = null)
    {
        if ($id != null) {
            $data = response()->json(
                Customer::find($id)
            );
        } else if ($searchTerm != null) {
            $data = response()->json(
                Customer::query()
                    ->where("name", 'LIKE', $searchTerm)
                    ->get()
            );
        } else {
            $data = response()->json(
                Customer::all()
            );
        }

        $response = [
            "data" => $data,
        ];
        return (new Response($response, 200))
            ->header('Content-Type', 'application/json');
    }

    /**
     * Retrives a single ticket
     * 
     * @param int $id
     * @return Response
     */
    public function getFromContact($num)
    {
        $data = response()->json(
            Customer::query()
                ->where("ph_number", '=', $num)
                ->get()
        );
        $response = [
            "data" => $data,
        ];
        return (new Response($response, 200))
            ->header('Content-Type', 'application/json');
    }

    /**
     * Creates a single customer
     * 
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        $param = $request->all()['param'];
        $customer = $param['customer'];
        $newCustomer = response()->json(Customer::create($customer));

        $response = [
            "data" => $newCustomer
        ];

        return (new Response($response, 200))
            ->header('Content-Type', 'application/json;charset=UTF-8')
            ->header('Charset', 'utf-8');
    }
}
