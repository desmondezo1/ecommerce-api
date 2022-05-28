<?php

namespace App\Http\Controllers;

use App\Models\partner;
use App\Models\Pieces;
use App\Models\product;
use App\Models\productImages;
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
        $products = Product::all(["id","title","description","price","offer_price","photo","status","updated_at"]);
        foreach ($products as &$product ){
            $images = product::find($product->id)->images;
            $images = $images->toArray();
            $product['photo'] = "https://via.placeholder.com/150";
            if(!empty($images)){
              $product['photo'] = $images[0]['image'];
            }
        }
        return ['status' => 200, 'desc' => 'Products fetched successfully', 'data'=> $products ];
    }

    public  function getSingleProduct($product_id){
        $product = product::find($product_id);
        $pieces = Pieces::where('product_id', $product_id)->get();

        if (is_null($product)){
            return ['status' => 500, 'desc' => 'Product Item not found', 'data'=> null ];
        }

        $product['images'] = product::find($product->id)->images;

            $brand = partner::find($product->brand_id);
            $product['brand'] = $brand->name;
            $product['variation'] = $pieces;

        return ['status' => 200, 'desc' => 'Product Fetched', 'data' => $product ];

    }

    /**
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
//        return $request->all();
        $validatedData = $this->validate($request,[
            'title' => ['required','unique:Products,title'],
//            'price' => 'required',
            'description' => 'required',
        ]);

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
            'weight' => $pieces[0]['weight'],
            'packaging' => $pieces[0]['packaging'],
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


//
        try {


            if ($request->hasFile('pdf')) {
                $original_filename = $request->file('pdf')->getClientOriginalName();
                $original_filename_arr = explode('.', $original_filename);
                $file_ext = end($original_filename_arr);
                $destination_path = 'public/uploads/products/pdf';
                $pdf = 'U-' . time() . '.' . $file_ext;

                if ($request->file('pdf')->move($destination_path, $pdf)) {
                    $productPayload['pdf'] = url('/').'/public/uploads/products/pdf/' . $pdf;
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
                        'packaging' => $piece['packaging'],
                        'weight' => $piece['weight'],
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

        //Add product
        $imagePayload = [];
        if ($request->has('image')){
            foreach ( $request->file('image') as $photo) {
                $original_filename = $photo->getClientOriginalName();
                $original_filename_arr = explode('.', $original_filename);
                $file_ext = end($original_filename_arr);
                $destination_path = 'public/uploads/products/';
                $image = 'U-' . time() . '.' . $file_ext;
                if ($photo->move($destination_path, $image)) {
                    $imagePayload[]['image'] =  url('/') . '/public/uploads/products/' . $image;
//                    $productPayload['photo'] = url('/') . '/public/uploads/products/' . $image;
                } else {
                    return $this->responseRequestError('Cannot upload file');
                }
            }
        }

        if(!empty($imagePayload)){
            foreach ($imagePayload as $img){
                $prodImage = productImages::create([
                    'product_id' => $product->id,
                    'image' => $img['image'],
                ]);
            }
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

    public function downloadPdf(Request $request){
        $path = $request->path;
        if(!$path){
            return ;
        }
        return response()->download($path);
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
