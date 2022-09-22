<?php

namespace App\Http\Controllers;

use App\Models\Worker;
use Illuminate\Http\Response;

class WorkerController extends Controller
{

    /**
     * Retrives a single ticket
     * 
     * @param int $id
     * @return Response
     */
    public function get($id = null)
    {
        $data = response()->json(Worker::find($id));
        $response = [
            "data" => $data,
        ];
        return (new Response($response, 200))
            ->header('Content-Type', 'application/json');
    }
}
