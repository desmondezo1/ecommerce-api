<?php

namespace App\Http\Controllers;

use App\Models\Pieces;
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
        $product = Product::all(["id","title","description","price","offer_price","photo","status","updated_at"]);
        return ['status' => 200, 'desc' => 'Products fetched successfully', 'data'=> $product ];
    }

    /**
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
//        $validatedData = $this->validate($request,[
//            'title' => ['required','unique:Products,title'],
////            'price' => 'required',
//            'description' => 'required',
//        ]);

        $pieces = json_decode($request->pieces,true);
        $tag =  json_decode($request->tag);
        $categories =  json_decode($request->category);
//
        $productPayload = [
            'title' => $request->title,
            'price' => $pieces[0]["price"][0],
            'description' => $request->description,
            'offer_price' => $pieces[0]["price"][1],
            'discount' => $pieces[0]["discount"][0],
            'status' => $request->status,
//            'photo' => $request->file('image'),
//            'photoCheck' => $request->hasFile('image'),
//            'pdf' => $request->file('pdf'),
//            'category_id' => $categories,
            'brand_id' => $request->brand,
            'volume' => $request->volume,
            'tag' => $request->tag,
            'surface' => $request->surface,
            'uses' => $request->uses,
        ];


            if ($request->hasFile('image')) {
                $original_filename = $request->file('image')->getClientOriginalName();
                $original_filename_arr = explode('.', $original_filename);
                $file_ext = end($original_filename_arr);
                $destination_path = 'public/uploads/products/';
                $image = 'U-' . time() . '.' . $file_ext;

                if ($request->file('image')->move($destination_path, $image)) {
                    $productPayload['photo'] = url('/') . '/public/uploads/products/' . $image;
                } else {
                    return $this->responseRequestError('Cannot upload file');
                }
            }

//
        try {


        if ($request->hasFile('pdf')) {
            $original_filename = $request->file('pdf')->getClientOriginalName();
            $original_filename_arr = explode('.', $original_filename);
            $file_ext = end($original_filename_arr);
            $destination_path = 'public/uploads/products/pdf';
            $image = 'U-' . time() . '.' . $file_ext;

            if ($request->file('pdf')->move($destination_path, $image)) {
                $productPayload['pdf'] = url('/').'/public/uploads/products/pdf/' . $image;
            } else {
                return $this->responseRequestError('Cannot upload file');
            }
        }

        }catch (\Exception $e){
            echo $e->getMessage();
        }


        try{
        $product = product::create($productPayload);
        if (!empty($pieces)){
            foreach ( $pieces as $piece){
                $pieceAdded = Pieces::create([
                    'product_id' =>  $product->id,
                    'title' => $product->title,
                    'category_id' => $product->category_id,
                    'description' => $product->description,
//                    'short_description' =>
                    'photo' => $product->photo,
                    'brand_id' => $product->brand_id,
                    'price' => $piece['price'][0],
                    'stock_status' => 'instock',
                    'offer_price' => $piece['price'][1],
                    'instock_quantity' => 10,
                    'discount' => $piece['discount'][0],
                    'status' => $product->status
                ]);
            }
        }
       }catch (\Exception $e){
           echo $e->getMessage();
       }

        try {
            $prd = product::find($product->id);
            $prd->category()->attach($categories);
        }catch (\Exception $e){
            echo $e->getMessage();
        }

        return ['status' => 200, 'desc' => 'Product created successfully', 'data'=> $product ];

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
            'discount' => 'Numeric' ,
            'status' => 'String',
            'category_id' => 'Numeric'
        ]);

        $product = Product::find($id);
        if (is_null($product)){
            return ['status' => 500, 'desc' => 'Product Item not found', 'data'=> null ];
        }
        isset($request->title) ? $product->title = $request->title: false;
        isset($request->price) ? $product->price = $request->price: false;
        isset($request->description) ? $product->description = $request->description: false;
        isset($request->offer_price) ? $product->offer_price = $request->offer_price: false;
        isset($request->photo) ? $product->photo = $request->photo: false;
        isset($request->discount) ?  $product->discount = $request->discount : false;
        isset($request->status) ? $product->status = $request->status: false;
        isset($request->category_id) ? $product->category_id = $request->category_id: false;
        $product->save();

        return ['status' => 200, 'desc' => 'Product Item has been updated', 'data' => $product ];

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $prod = Product::destroy($id);
        if (!$prod){
            return ['status' => 500, 'desc' => 'Product Item was not deleted' ];
        }

        return ['status' => 200, 'desc' => 'Product Item has been deleted successfully' ];

    }
}
