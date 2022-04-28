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

    private function getProductsArrayForPayment($product_ids){
        $productArray = [];
        foreach ($product_ids as $id){
            $product = product::find($id);
            if(!is_null($product)){
              $rr =  [
                    'price_data' => [
                        'currency' => 'ngn',
                        'product_data' => [
                            'name' => 'T-shirt',
                        ],
                        'unit_amount' => $product['price'],
                        ],
                    'quantity' => 3,
                    ];
            }

        }
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

        $product_ids = explode(',',$order['product_id']);
        $product_ids = $this->convertStrgToNum($product_ids);
        return $product_ids;

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
                [
                'price_data' => [
                    'currency' => 'ngn',
                    'product_data' => [
                        'name' => 'T-shirt',
                    ],
                    'unit_amount' => 200000,
                ],
                'quantity' => 1,
                ],
                [
                    'price_data' => [
                        'currency' => 'ngn',
                        'product_data' => [
                            'name' => 'T-shirt',
                        ],
                        'unit_amount' => 240000,
                    ],
                    'quantity' => 3,
                ]
            ],
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
