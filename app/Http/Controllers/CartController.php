<?php

namespace App\Http\Controllers;

use App\Models\cart;
use App\Models\product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($user_id)
    {
        $cart = cart::where('user_id', $user_id)->get();
        return ['status' => 200, 'desc' => 'Cart Fetched successfully', 'data' => $cart ];
    }


    /**
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function addItemToCart(Request $request)
    {
        $this->validate($request,[
            'product_id' => ['Required','Numeric','exists:products,id', 'unique:carts,product_id'],
            'user_id' => ['Required','Numeric','exists:users,id'],
            'price' => ['Required','Numeric'],
            'quantity' => ['Required','Integer'],
        ]);

        $cart = cart::create([
            'product_id' => $request->product_id,
            'user_id' => $request->user_id,
            'price' => $request->price,
            'quantity' => $request->quantity,

        ]);

        $cart->save();
        return ['status' => 200, 'desc' => 'Item has been added to cart', 'data'=> $cart ];

    }

    /**
     *
     *
     * @param $user_id
     * @param $product_id
     * @return \Illuminate\Http\Response
     */
    public function deleteItemFromCart( $user_id ,$product_id){

        $cart = cart::where('product_id',$product_id)->where('user_id', $user_id)->first();

        if (is_null($cart)){
            return ['status' => 500, 'desc' => 'Product Item doesn\'t exist on cart', 'data'=> $cart ];
        }
        $cart->delete();

        return ['status' => 200, 'desc' => 'Item has removed from cart'];

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $user_id, $product_id)
    {
        $this->validate($request,[
            'quantity' => ['Integer'],
                'order_id' => ['Integer'],
        ]);

        $cart = cart::where('user_id', $user_id)->where('product_id', $product_id)->first();
        if (is_null($cart)){
            return ['status' => 500, 'desc' => 'Item not found on User cart' ];
        }
        isset($request->quantity) ? $cart->quantity = $request->quantity : false;
        isset($request->order_id) ? $cart->order_id = $request->order_id : false;
        $cart->save();

        return ['status' => 200, 'desc' => 'Cart Item Updated successfully', 'data' => $cart ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy($user_id)
    {
        $cart = cart::where('user_id',$user_id)->get();
        if ($cart->isEmpty()){
            return ['status' => 500, 'desc' => 'User cart doesn\'t exist ', 'data'=> $cart ];
        }
        foreach($cart as $cart_item){
            cart::find($cart_item->id)->delete();
        }
//        $cart->delete();
        return ['status' => 200, 'desc' => 'Cart has been emptied', 'data'=> ['count' => count($cart)] ];

    }
}
