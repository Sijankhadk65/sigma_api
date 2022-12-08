<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Sales;
use App\Models\SalesItem;
use App\Models\StockItem;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class StockController extends Controller
{
    /**
     * Instantiate new TicketController instance.
     * 
     * @return void
     */
    public function __construct()
    {
    }


    /**
     * Get the stock of a certain center
     * 
     * @param Request $request
     * @param String $id
     * @return Response
     */
    public function getStockItems(Request $request, $id = NULL)
    {
        if ($id != NULL) {
            $stockItems = response()->json(StockItem::query()
                ->where("center_id", "=", $id)
                ->get());

            $response = [
                "data" => $stockItems,
            ];
            return (new Response($response, 200))
                ->header('Content-type', 'application/json')
                ->header('charset', 'utf-8');
        }
    }

    /**
     * Creates a single entity of the type Stock Item
     * @param Request $request
     * @return Response
     */
    public function createStockItem(Request $request)
    {
        $param = $request->all()['param'];
        $stockItem = $param['stockItem'];

        $newStockItem = response()->json(StockItem::create($stockItem));

        $response = [
            "data" => $newStockItem,
        ];

        return (new Response($response, 200))
            ->header('Content-type', 'application/json')
            ->header('charset', 'utf-8');
    }

    /**
     * Uploads the photo of an item to the server
     * 
     * @param  Request $request
     * @return Response  
     */
    public function uploadPhoto(Request $request)
    {
        $param = $request->all()['param'];
        $base64_string = $param['image'];
        $outputfileName = $param['imageName'];
        try {
            $fileHandler = fopen(getcwd() . '/photos/stock_items/' . $outputfileName, 'wb');
            fwrite($fileHandler, base64_decode($base64_string));
            fclose($fileHandler);
            $data = response()->json([
                "image_path" => '/photos/stock_items/' . $outputfileName,
            ]);
            $exception = "";
        } catch (\Throwable $th) {
            $data = response()->json([
                "image_path" => '',
            ]);
            $exception = $th->getMessage();
        }
        $data->exception = $exception;
        $response = [
            "data" => $data,
        ];
        return $response;
        // (new Response($response, 200))
        //     ->header('Content-type', 'application/json')
        //     ->header('charset', 'utf-8');
    }

    /**
     * Deletes a single stock item
     * 
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function deleteStockItem(Request $request, $id)
    {
        try {
            $status = StockItem::findOrFail($id)->delete();
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

    /**
     * Updates a single stock item
     * 
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function updateStockItem(Request $request, $id)
    {
        $item = StockItem::findOrFail($id);
        $param  = $request->all()['param'];
        $updateParams = $param;

        if (isset($param['command']) && isset($param['quantity'])) {
            if ($param['command'] == "increase") {
                $updateParams = [
                    "quantity" => $item->quantity + $param['quantity']
                ];
            } elseif ($param['command'] == "decrease") {
                $updateParams = [
                    "quantity" => $item->quantity - $param['quantity']
                ];
            }
        }
        $item->update($updateParams);
        $item = StockItem::findOrFail($id);
        return (new Response($item, 200))
            ->header('Content-Type', 'application/json');
    }
}
