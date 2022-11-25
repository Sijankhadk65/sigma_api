<?php

namespace App\Http\Controllers;

use App\Models\Balance;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class BalanceController extends Controller
{


    /**
     * Retrives all the balances of a certain center
     * 
     * @param Request $request
     * @param String $id
     * @return Response
     */
    public function get(Request $request, $id = null)
    {
        if ($id != null) {
            $balances = response()->json(Balance::query()
                ->where('center_id', '=', $id)
                ->get());
        }

        $response = [
            "data" => $balances
        ];
        return (new Response($response, 200))
            ->header('Content-type', 'application/json')
            ->header('charset', 'utf-8');
    }

    /**
     * Creates a balance for a certain center
     * 
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        $param = $request->all()['param'];
        $balance = $param['balance'];

        $newBalance = response()->json(Balance::create($balance));

        $response = [
            "data" => $newBalance,
        ];

        return (new Response($response, 200))
            ->header('Content-type', 'application/json')
            ->header('charset', 'utf-8');
    }
}
