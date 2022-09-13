<?php

namespace App\Http\Controllers;

use App\Models\product;
use App\Models\productImages;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($user_id)
    {

        $user = User::find($user_id);
        if(is_null($user)){
            return ['status' => 500, 'desc' => 'Invalid User' ];
        }

        $wishlist = Wishlist::where('user_id', $user_id)->get();

        if(is_null($wishlist)){
            return ['status' => 500, 'desc' => 'Wishlist empty' ];
        }

        $list = [];
        foreach ($wishlist as $wish){
            $prod = product::find($wish['product_id']);
            $pic = productImages::where('product_id', $wish['product_id'])->first();
            if($pic){
                $prod['photo'] = $pic;
            }
            $list[] = $prod;
        }

        return ['status' => 200, 'desc' => 'Wishlist fetched successfully', 'data'=> $list ];

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($user_id, Request $request)
    {

        $user = User::find($user_id);
        $product = product::find($request->product_id);
        $prodInWish = Wishlist::where("product_id", $request->product_id)->first();

        if (!is_null($prodInWish)){
            return ['status' => 200, 'desc' => 'Product added to wishlist', 'data'=> $prodInWish ];
        }

        if(is_null($user) || is_null($product)){
            return ['status' => 500, 'desc' => 'Invalid User / Product' ];
        }


        $wishlist =  Wishlist::create([
            "user_id" => $user_id,
            "product_id" => $request->product_id
        ]);

        return ['status' => 200, 'desc' => 'Product added to wishlist', 'data'=> $wishlist ];
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($user_id, Request $request)
    {
        $user = User::find($user_id);
        $product = product::find($request->product_id);

        if(is_null($user) || is_null($product)){
            return ['status' => 500, 'desc' => 'Invalid User / Product' ];
        }

        $wishlist = Wishlist::where('product_id', $request->product_id)->delete();

        return ['status' => 200, 'desc' => 'Item Removed successfully', 'data'=> $wishlist ];

    }
}
