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

        if (isset($param['reduce_quantity_by'])) {
            $newQuantity = $item->quantity - $param['reduce_quantity_by'];
            $newParams = [
                "quantity" => $newQuantity
            ];
            $item = $item->update($newParams);
        }

        $item = StockItem::findOrFail($id);
        return (new Response($item, 200))
            ->header('Content-Type', 'application/json');
    }
}
