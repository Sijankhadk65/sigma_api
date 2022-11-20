<?php

namespace App\Http\Controllers;

use App\Models\Worker;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class WorkerController extends Controller
{

    /**
     * Retrives a single ticket
     * 
     * @param String $id
     * @return Response
     */
    public function get($id = null)
    {
        if ($id == null) {
            $data = response()->json(Worker::all());
        } else {
            $data = response()->json(
                Worker::find($id)
            );
        }

        $response = [
            "data" => $data,
        ];
        return (new Response($response, 200))
            ->header('Content-Type', 'application/json');
    }

    /**
     * Retives the worker of a certain service center
     * 
     * @param String $center_id
     * @return Resposne 
     */
    public function getCenterWorkers($center_id)
    {
        $data = response()->json(
            Worker::query()
                ->where('center_id', '=', $center_id)
                ->get()
        );

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
            $param = $request->all()['param'];
            $newWorker = Worker::create($param);
        }
        return (new Response($newWorker, 200))
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
