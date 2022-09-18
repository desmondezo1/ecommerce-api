<?php

namespace App\Http\Controllers;

use App\Models\cart;
use App\Models\order;
use App\Models\order_items;
use App\Models\pricingTable;
use App\Models\product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $orders = order::orderBy('created_at','desc')->get();
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
        $prd_details=[];

        $prods = json_decode($order->product_id, true);

         for ($i = 0; count($prods) > $i; $i++){
            $prd_details[] = product::find($prods[$i]['id']);
         }
         $order['prd_details'] = $prd_details;

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
        $order = order::where('user_id',$user_id)->orderByDesc('created_at')->get();

        if (is_null($order)){
            return ['status' => 500, 'desc' => 'Order not found' ];
        }
        $item = [];
        foreach ($order as $ord){
            //get items from the order items table
            $val = order_items::where('order_id', $ord->id)->get();
            $item = array_merge($item, $val->toArray());
        }
        $resll = [];
        foreach($item as $it){
            if(!is_null($it['product_id'])){
                $prod = product::find($it['product_id']);
                array_push($resll, $prod);
            }
        }

        return ['status' => 200, 'desc' => 'Order fetched successfully', 'data'=> $resll ];

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
        $tax = 0;
        $products = [];

//        $this->validate($request,[
//            'user_id' => ['Required'],
//            'shipping_type' => ['Required', 'Integer', 'exists:shipping_types,id'],
//            'delivery_charge' => ['Required','Numeric'],
//            'status' => ['Required','Integer','exists:order_status,id'],
//            'payment_method' => ['Required', 'Integer'],
//        ]);

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
            $products[] = ["id" => $product['product_id'], "qty" => $product['quantity'], "price" => $product['price']];
        }


        if($request->delivery_charge){
            $delivery_charge = $request->delivery_charge;
        }

        if($request->tax){
            $tax = $request->tax;
        }

        $total_amount = $sub_total + $delivery_charge;

        if($tax){
            $total_amount += $tax;
        }

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

    public function calculateShippingFromWeight($weight){

//        $userCart = cart::where('user_id', $user_id)->get();
//        $arrOfWeight = [];
//        $costArr = [];

//        if(!$userCart){
//            return response()->json(["msg" => "Cart is empty invalid"], 500);
//        }
//
//        foreach ($userCart as $cartItem){
//            $item = product::find($cartItem->product_id);
//            $arrOfWeight[] = $item->volume;
//        }

//        if(empty($arrOfWeight)){
//            return response()->json(["msg" => "Weight not found"], 500);
//        }

//        foreach ($arrOfWeight as $weight) {
//            $cost = pricingTable::where('max_weight', '<=', $weight)->where('min_weight', '>=', $weight)->get();

        $cost = DB::table('pricing_table')
            ->select('price','max_weight','min_weight')
            ->where('max_weight', '<=',  $weight)
            ->where('min_weight', '>',  $weight)
            ->get()
            ->first();
//            $finalCost = $cost->value('price');
//        }

//        $sumCost = 0;
//        foreach ($costArr as $p){
//            $sumCost += $p;
//        }

        return response()->json(["data" => $weight], 200);

    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\order  $order
     * @return \Illuminate\Http\Response
     */
    public function updateOrder(Request $request, $order_id){

        $order = order::find($order_id);
        if(!$order){
            return response()->json(["msg" => "order invalid"], 402);
        }

        if($request->order_status){
            $order->status = $request->order_status;
        }
        if ($request->payment_status){
            $order->payment_status = $request->payment_status;
        }
        $order->save();

        return ['status' => 200, 'desc' => 'Order updated successfully', 'data'=> $order];
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
