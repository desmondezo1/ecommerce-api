<?php

namespace App\Http\Controllers;

use App\Models\order;
use App\Models\payments;
use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Stripe\Stripe;
use Ramsey\Uuid\Uuid;

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
        $uuid = Uuid::uuid4();
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
        $trans = payments::create([
            "trans_id" => $uuid->toString(),
            "user_id" => $order["user_id"],
            "order_id" => $order["id"],
            "trans_status" => "INITIATED",
             "amount" => $order["total_amount"],
             "description" => "Payment for Products"
        ]);

        Stripe::setApiKey(env("STRIPE_SECRETE_KEY"));
        $session = \Stripe\Checkout\Session::create([
            'line_items' =>
                [$stripeProducts],
            'mode' => 'payment',
//            'success_url' => env("APP_URL").'/api/payment/success/'.$trans['trans_id']."/".$order["id"],
            'success_url' => env("FRONTEND_APP_URL").'/api/payment/success?transid='.$trans['trans_id']."&orderid=".$order["id"],
//            'cancel_url' => env("APP_URL").'/api/payment/cancel',
            'cancel_url' => env("FRONTEND_APP_URL").'/api/payment/failure?transid='.$trans['trans_id']."&orderid=".$order["id"],
        ]);

        $paymentT = payments::find($trans['id']);
        $paymentT->stripe_payment_status = $session['payment_status'];
        $paymentT->stripe_payment_intent = $session['payment_intent'];
        $paymentT->stripe_payment_currency = $session['currency'];
        $paymentT->stripe_payment_id = $session['id'];
        $paymentT->save();
        return  ['status' => 200, 'url'=> $session['url']];

    }


    public function success($trans_id, $order_id){
       $transactionRecord = payments::where("trans_id", $trans_id)->first();
       $order = order::find($order_id);
       if (is_null($transactionRecord) || is_null($order)){
           return ['status' => 500, 'desc' => 'Invalid details provided'];
       }

        $transactionRecord ->trans_status = "COMPLETED";
        $transactionRecord ->stripe_payment_status = "paid";
        $transactionRecord ->save();
        $order->payment_status = 1;
        $order->save();
        return ['status' => 200, 'desc' => 'Payment Success'];

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
