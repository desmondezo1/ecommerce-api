<?php

namespace App\Http\Controllers;

use App\Models\product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return product[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Http\Response
     */
    public function index()
    {
        return Product::all(["id","title","description","price","offer_price","photo"]);
    }

    /**
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validatedData = $this->validate($request,[
            'title' => ['required','unique:Products,title'],
            'price' => 'required',
            'description' => 'required'
        ]);

        $product = product::create([
            'title' => $request->title,
            'price' => $request->price,
            'description' => $request->description,
            'offer_price' => $request->offer_price,
            'photo' => $request->photo,
            'discount' => $request->discount,
            'status' => $request->status,
            'category_id' => $request->category_id,
        ]);

        return $product ;
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
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'title' => 'String',
            'price' => 'Numeric',
            'description' => 'String',
            'offer_price' => 'Numeric',
            'photo' => 'String',
            'discount' => 'Numeric' ,
            'status' => 'String',
            'category_id' => 'Numeric'
        ]);

        $product = Product::find($id);
        isset($request->title) ? $product->title = $request->title: false;
        isset($request->price) ? $product->price = $request->price: false;
        isset($request->description) ? $product->description = $request->description: false;
        isset($request->offer_price) ? $product->offer_price = $request->offer_price: false;
        isset($request->photo) ? $product->photo = $request->photo: false;
        isset($request->discount) ?  $product->discount = $request->discount : false;
        isset($request->status) ? $product->status = $request->status: false;
        isset($request->category_id) ? $product->category_id = $request->category_id: false;
        $product->save();

        return $product;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Product::destroy($id);
    }
}
