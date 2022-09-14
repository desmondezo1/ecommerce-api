<?php

namespace App\Http\Controllers;

use App\Models\partner;
use App\Models\Pieces;
use App\Models\product;
use App\Models\productImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return product[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Http\Response
     */
    public function index()
    {
        $products = product::with('category')->get(["id","title","description","discount","price","offer_price","photo","status","updated_at"]);
        foreach ($products as &$product ){
            if ($product->status == "unpublished"){ continue;}

            $images = product::find($product->id)->images;
            $categories = product::find($product->id)->images;
            $images = $images->toArray();
            $product['photo'] = "https://via.placeholder.com/150";
            $brand = partner::find(8);
            $product['brand'] = $brand['name'];
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
        }else if ($product->status == "unpublished"){
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
            'title' => ['required','unique:products,title'],
//            'price' => 'required',
            'description' => 'required',
        ]);

        $pieces = json_decode($request->pieces,true);
        $tag =  json_decode($request->tag);
        $categories =  json_decode($request->category);
//
        $productPayload = [
            'title' => $request->title,
            'description' => $request->description,
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

        if(isset($pieces)){
            $productPayload['price'] = $pieces[0]["price"][0];
            $productPayload['offer_price'] = $pieces[0]["price"][1];
            $productPayload['discount'] = $pieces[0]["discount"][0];
            $productPayload['weight'] = $pieces[0]['weight'];
            $productPayload['packaging'] = $pieces[0]['packaging'];
        }else{
            $productPayload['price'] = 0;
            $productPayload['brand_id'] = 1;
        }


//
        try {


            if ($request->hasFile('pdf')) {
                $original_filename = $request->file('pdf')->getClientOriginalName();
                $original_filename_arr = explode('.', $original_filename);
                $file_ext = end($original_filename_arr);
                $destination_path = 'public/uploads/products/pdf';
                $pdf = 'U-' . time() . '.' . $file_ext;

                if ($request->file('pdf')->move($destination_path, $pdf)) {
                    $productPayload['pdf'] = url('/').'/public/public/uploads/products/pdf/' . $pdf;
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
                    $imagePayload[]['image'] =  url('/') . '/public/public/uploads/products/' . $image;
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

        $product = Product::find($id);

        $prodImages = productImages::where('product_id',$id)->get();
        $productPayload = [];

        if (is_null($product)){
            return ['status' => 500, 'desc' => 'Product Item not found', 'data'=> null ];
        }


        $pieces = json_decode($request->pieces,true);
        $tag =  json_decode($request->tag);
        $categories =  json_decode($request->category);
//
        if(isset($pieces)){
            $productPayload['price'] = $pieces[0]["price"][0];
            $productPayload['offer_price'] = $pieces[0]["offer_price"][0];
            $productPayload['discount'] = $pieces[0]["discount"][0];
            $productPayload['weight'] = $pieces[0]['weight'];
            $productPayload['packaging'] = $pieces[0]['packaging'];
        }else{
            $productPayload['price'] = 0;
            $productPayload['brand_id'] = 1;
        }

        try {


            if ($request->hasFile('pdf')) {
                $original_filename = $request->file('pdf')->getClientOriginalName();
                $original_filename_arr = explode('.', $original_filename);
                $file_ext = end($original_filename_arr);
                $destination_path = 'public/uploads/products/pdf';
                $pdf = 'U-' . time() . '.' . $file_ext;

                if ($request->file('pdf')->move($destination_path, $pdf)) {
                    $productPayload['pdf'] = url('/').'/public/public/uploads/products/pdf/' . $pdf;
                } else {
                    return $this->responseRequestError('Cannot upload file');
                }
            }

        }catch (\Exception $e){
            echo $e->getMessage();
        }


        isset($request->title) ? $product->title = $request->title: false;
        isset($productPayload['price']) ? $product->price = $productPayload['price']: false;
        isset($request->description) ? $product->description = $request->description: false;
        isset($productPayload['offer_price']) ? $product->offer_price = $productPayload['offer_price']: false;
        isset($request->photo) ? $product->photo = $request->photo: false;
        isset($productPayload['discount']) ?  $product->discount = $productPayload['discount'] : false;
        isset($request->status) ? $product->status = $request->status: false;
        isset($request->tag) ? $product->tag = $request->tag: false;
        isset($request->volume) ? $product->volume = $request->volume: false;
        isset($productPayload['weight']) ? $product->weight = $productPayload['weight']: false;
        isset($request->surface) ? $product->surface = $request->surface: false;
        isset($request->uses) ? $product->uses = $request->uses: false;
        isset($request->brand_id) ? $product->brand_id = $request->brand_id: false;
        isset($request->category_id) ? $product->category_id = $request->category_id: false;
        isset($productPayload['packaging']) ? $product->packaging = $productPayload['packaging']: false;
        $product->save();

        try {
            if (!empty($pieces)){
                try {
                    $piecesResult = Pieces::where('product_id',$id)->delete();
                }catch(\Exception $e){

                }

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
                        'offer_price' => $piece['offer_price'][0],
                        'instock_quantity' => 10,
                        'discount' => $piece['discount'][0],
                        'status' => $product->status
                    ]);
                }
            }
        }catch(\Exception $e){

        }


        //Add product
        $imagePayload = [];
        if ($request->has('image')){

            //Delete existing images
            if ($prodImages){
                foreach ($prodImages as $prodImg){
                    try {
                        unlink($prodImg->image);
                    }catch (\Exception $e){
                    }
                }
            }


            foreach ( $request->file('image') as $photo) {
                $original_filename = $photo->getClientOriginalName();
                $original_filename_arr = explode('.', $original_filename);
                $file_ext = end($original_filename_arr);
                $destination_path = 'public/uploads/products/';
                $image = 'U-' . time() . '.' . $file_ext;
                if ($photo->move($destination_path, $image)) {
                    $imagePayload[]['image'] =  url('/') . '/public/public/uploads/products/' . $image;
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

        return ['status' => 200, 'desc' => 'Product updated successfully', 'data'=> $product ];

    }

    public function updateStatus(Request $request, $id){
        $product = Product::find($id);
        if (is_null($product)){
            return ['status' => 500, 'desc' => 'Product Item not found', 'data'=> null ];
        }

        if ($request->status){
            $product->status = $request->status;
            return ['status' => 200, 'desc' => 'Product Item updated', 'data'=> $product->save() ];
        }else{
            return ['status' => 500, 'desc' => 'Payload can\'t be empty', 'data'=> null ];
        }

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

    public function deleteImage($imageId){
        //find image
        $image = productImages::find($imageId);
        if (!$image){
            return ['status' => 500, 'desc' => 'File Item was not found','data'=>['status' => 500, 'desc' => 'File Item was not found'] ];
        }
        $relPath = str_replace(url('/'), "",$image->image);

        if(File::exists($relPath)) {
           File::delete($relPath);
            try {
                $reult =$image->delete();
            }catch (\Exception $e){
                return ['status' => 500, 'desc' => 'File Item was not deleted : '.$e->getMessage() ,'data'=>['status' => 500, 'desc' => 'File Item was not deleted : '.$e->getMessage()]];
            }
            return ['status' => 200, 'desc' => 'File Item has been deleted successfully' ,"data" => ['status' => 200, 'desc' => 'File Item has been deleted successfully']];
        }else{
            $image->delete();
            return ['status' => 200, 'desc' => 'File Item has been deleted successfully' ,"data" => ['status' => 200, 'desc' => 'File Item has been deleted successfully']];
        }

    }
}
