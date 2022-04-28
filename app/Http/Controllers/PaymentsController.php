<?php

namespace App\Http\Controllers;

use App\Models\order;
use App\Models\payments;
use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Stripe\Stripe;

class PaymentsController extends Controller
{

    private  function convertStrgToNum($arrval){
        $arr = [];
        foreach ($arrval as $val){
            if ((int)$val !== 0) {
                array_push($arr, (int)$val);
            }
        }
        return  $arr;
    }

    private function getStripePrd($products){
        $productArray = [];
        foreach ($products as $prd){
            $product = product::find($prd['id']);
            if(!is_null($product)){
              $rr =  [
                    'price_data' => [
                        'currency' => 'ngn',
                        'product_data' => [
                            'name' => $product['title'],
                        ],
                        'unit_amount' => $product['price'] * 100,
                        ],
                    'quantity' => $prd['qty'],
                    ];
            }
            $productArray[] = $rr;
        }
        return $productArray;
    }

    public function checkout(Request $request, Response $response){

//        $transId
//        $this->validate($request,[
//            "order_id" => "exists:orders,id"
//        ]);

        $orderId = $request->order_id;

        $order = order::find($orderId);
        if (is_null($order)){
            return ['status' => 401, 'desc' => 'Order not found'];
        }

        $products = json_decode($order['product_id'], true);
        $stripeProducts = $this->getStripePrd($products);
        return $stripeProducts;

        //order id
        //user order
        //get order with details
        //loop and create price_data from products table
        //Transaction recording should start
        //create transId
        // add TransId and Order Id to success
        // add TransId and Order Id to failure

//        [
//            'price_data' => [
//                'currency' => 'ngn',
//                'product_data' => [
//                    'name' => 'T-shirt',
//                ],
//                'unit_amount' => 240000,
//            ],
//            'quantity' => 3,
//        ]



        Stripe::setApiKey(env("STRIPE_SECRETE_KEY"));
        $session = \Stripe\Checkout\Session::create([
            'line_items' => [
                [$stripeProducts],
            'mode' => 'payment',
            'success_url' => env("APP_URL").'/payment/success?t='.$transId."&o=".$orderId,
            'cancel_url' => env("APP_URL").'/payment/cancel',
        ]);
        return  $session ;

    }




    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\payments  $payments
     * @return \Illuminate\Http\Response
     */
    public function show(payments $payments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\payments  $payments
     * @return \Illuminate\Http\Response
     */
    public function edit(payments $payments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\payments  $payments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, payments $payments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\payments  $payments
     * @return \Illuminate\Http\Response
     */
    public function destroy(payments $payments)
    {
        //
    }
}
