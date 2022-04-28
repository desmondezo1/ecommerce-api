<?php

namespace App\Http\Controllers;

use App\Models\payments;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Stripe\Stripe;

class PaymentsController extends Controller
{

    public function checkout(Request $request, Response $response){
        //order id
        //user order
        //get order with details
        //loop and create price_data from products table
        //Transaction recording should start
        //create transId
        // add TransId and Order Id to success
        // add TransId and Order Id to failure




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
            'success_url' => env("APP_URL").'/success',
            'cancel_url' => env("APP_URL").'/cancel',
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
