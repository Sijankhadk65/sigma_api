<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Sales;
use App\Models\SalesItem;
use App\Models\StockItem;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use \Illuminate\Foundation\Testing\Concerns\MakesHttpRequests;

class SalesController extends Controller
{

    protected $baseUrl = null;
    protected $app = null;


    /**
     * Instantiate new TicketController instance.
     * 
     * @return void
     */
    public function __construct()
    {
        $this->baseUrl = request()->getSchemeAndHttpHost();
        $this->app     = app();
    }

    /**
     * Retrives the sales info of the center
     * 
     * @param Request $request
     * @param String $id
     * @return Response
     */
    public function get(Request $request, $id = NULL)
    {
        if ($id != NULL) {
            $sales = Sales::query()
                ->where("center_id", "=", $id)
                ->get();
            $sales = response()->json($sales);
            $response = [
                "data" => $sales,
            ];
            return (new Response($response, 200))
                ->header('Content-type', 'application/json')
                ->header('charset', 'utf-8');
        }
    }

    /**
     * Get the items for a sale
     */
    public function getItems(Request $request, $id = NUll)
    {
        if ($id != NULL) {

            $salesItems = SalesItem::query()
                ->where("sales_id", "=", $id)
                ->get();
            $salesItems = response()->json($salesItems);
            $response = [
                "data" => $salesItems,
            ];

            return (new Response($response, 200))
                ->header('Content-type', 'application/json')
                ->header('charset', 'utf-8');
        }
    }

    /**
     * Creates a single element of sale
     * 
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        $param = $request->all()['param'];
        $sales = $param['sales'];
        $salesItems = $param['salesItems'];
        $customer = $param['customer'];

        $newCustomer = Customer::create($customer);
        $sales['customer_id'] = $newCustomer->id;
        $newSales = Sales::create($sales);

        foreach ($salesItems as $item) {
            $item['sales_id'] = $newSales->id;
            $stockItem = StockItem::find($item['item_id']);
            $newQuantity = $stockItem->quantity - $item['quantity'];
            $newParams = [
                "quantity" => $newQuantity
            ];
            $stockItem = $stockItem->update($newParams);
            $newSalesItem = SalesItem::create($item);
        }

        $response = [
            "data" => response()->json($newSales),
        ];

        return (new Response($response, 200))
            ->header('Content-type', 'application/json')
            ->header('charset', 'utf-8');
    }
}
