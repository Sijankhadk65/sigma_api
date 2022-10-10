<?php

namespace App\Http\Controllers;

use App\Models\Worker;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

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
        if ($id == null) {
            $data = response()->json(Worker::all());
        } else {
            $data = response()->json(Worker::find($id));
        }

        $response = [
            "data" => $data,
        ];
        return (new Response($response, 200))
            ->header('Content-Type', 'application/json');
    }

    /**
     * Create an item of Worker Model
     * 
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        if ($request->getMethod() == "POST") {
            $param = json_decode($request->all()['param']);
            $worker = json_decode($param->worker,true);
            $newWorker = Worker::create($worker);
        }
        return (new Response($newWorker,200))
            ->header('Content-Type', 'application/json;charset=UTF-8')
            ->header('Charset', 'utf-8');
        
    }

    /**
     * Updates a single worker
     * 
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $worker = Worker::findOrFail($id);
        $worker->update($request->all());
        
        return (new Response($worker, 200))
            ->header('Content-Type', 'application/json');
    }


    /**
     * Deletes a single worker
     * 
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function delete(Request $request, $id)
    {
        try {
            $status = Worker::findOrFail($id)->delete();
            return (new Response([
                'status'  => 1,
                'message' => "Delete Successful",
            ], 200))
            ->header('Content-Type', 'application/json');
        } catch (ModelNotFoundException $th) {
            return (new Response([
                'status'  => 0,
                'message' => $th->getMessage(),
            ], 200))
            ->header('Content-Type', 'application/json');
        }        
    }

}
