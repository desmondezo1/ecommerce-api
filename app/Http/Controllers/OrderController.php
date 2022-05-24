<?php

namespace App\Http\Controllers;

use App\Models\cart;
use App\Models\order;
use App\Models\order_items;
use App\Models\product;
use App\Models\User;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = order::all();
        return ['status' => 200, 'desc' => 'Fetched Orders', 'data'=> $orders ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getOrder($order_id)
    {
        $order = order::find($order_id);
        if (is_null($order)){
            return ['status' => 500, 'desc' => 'Order not found' ];
        }
        return ['status' => 200, 'desc' => 'Order fetched successfully', 'data'=> $order ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getUserOrders($user_id)
    {

        $user = User::find($user_id);
        if (is_null($user)){
            return ['status' => 500, 'desc' => 'User not found' ];
        }

       //grab all orders for user
        $order = order::where('user_id',$user_id)->get();

        if (is_null($order)){
            return ['status' => 500, 'desc' => 'Order not found' ];
        }
        $item = [];
        foreach ($order as $ord){
            //get items from the order items table
            $val = order_items::where('order_id', $ord->id)->get();
            $item = array_merge($item, $val->toArray());
        }

        return ['status' => 200, 'desc' => 'Order fetched successfully', 'data'=> $item ];

    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $uuid = Uuid::uuid4();
        $total_amount = 0;
        $sub_total = 0;
        $delivery_charge = 0;
        $products = [];

        $this->validate($request,[
            'user_id' => ['Required'],
            'shipping_type' => ['Required', 'Integer', 'exists:shipping_types,id'],
            'delivery_charge' => ['Required','Numeric'],
            'status' => ['Required','Integer','exists:order_status,id'],
            'payment_method' => ['Required', 'Integer'],
        ]);

        $user = User::find($request->user_id);

        if(is_null($user)){
            return ['status' => 401, 'desc' => 'Can\'t create order, User not found'];
        }

        $cart = cart::where('user_id',$user->id)->get();

        if(is_null($cart) || $cart->isEmpty()){
            return ['status' => 500, 'desc' => 'User Cart is empty'];
        }

        foreach ($cart as $product){
            $sub_total += ($product['price'] * $product['quantity']);
            $products[] = ["id" => $product['product_id'], "qty" => $product['quantity']];
        }


        if($request->delivery_charge){
            $delivery_charge = $request->delivery_charge;
        }

        $total_amount = $sub_total + $delivery_charge;
        try {
            $order =  order::create([
                "user_id" => $user->id,
                'order_number' => 'MCS'. $uuid->toString(),
                "sub_total" => $sub_total,
                "product_id" => json_encode($products),
                "total_amount" => $total_amount,
                "delivery_charge" => $delivery_charge,
                "first_name" => $user->first_name,
                "last_name" => $user->last_name,
                "email" => $user->email,
                "phone" => $user->phone,
                "address" => $user->address,
                "shipping_type" => $request->shipping_type
            ]);
        } catch(Exception $e){
            return ['status' => 500, 'desc' => 'Couldnt create order', 'data'=> $e->getMessage()];
        }


        if (!is_null($order)){

            foreach ($products as $produ){

                try {
                    $orderItems = order_items::create([
                        "order_id" => $order->id,
                        "quantity" => $produ['qty'],
                        "product_id" => (int)$produ["id"]
                    ]);
                } catch (Exception $e){
                    return ['status' => 500, 'desc' => 'Couldnt create order', 'data'=> $e->getMessage()];
                }

            }
        }
        cart::where('user_id',$user->id)->delete(); //delete cart when user creates order.
        return ['status' => 200, 'desc' => 'Order created successfully', 'data'=> $order];


    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $order_id){


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy($order_id)
    {
        try {
            order::destroy($order_id);
            return ['status' => 200, 'desc' => 'Order deleted successfully'];
        } catch(\Exception $e){
            return ['status' => 500, 'desc' => 'Order Couldn\'t be deleted : '. $e->getMessage()];

        }
    }
}
