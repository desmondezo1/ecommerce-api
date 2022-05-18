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
        $product = Product::all(["id","title","description","price","offer_price","photo"]);
        return ['status' => 200, 'desc' => 'Products fetched successfully', 'data'=> $product ];
    }

    /**
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
//        echo $_POST['title'];
//        $validatedData = $this->validate($request,[
//            'title' => ['required','unique:Products,title'],
////            'price' => 'required',
//            'description' => 'required',
//        ]);

//        if ($request->hasFile('photo')) {
//            $fileExtension = $request->file('photo')->getClientOriginalName();
//            $file = pathinfo($fileExtension, PATHINFO_FILENAME);
//            $extension = $request->file('photo')->getClientOriginalExtension();
//            $fileStore = $file . '_' . time() . '.' . $extension;
//            $photoPath = $request->file('photo')->move('public/photos', $fileStore);
//        }
//
//        $product = product::create([
//            'title' => $request->title,
//            'price' => $request->pieces[0]->price,
//            'description' => $request->description,
//            'offer_price' => $request->offer_price,
//            'photo' => $photoPath,
//            'discount' => $request->discount,
//            'status' => $request->status,
//            'category_id' => $request->category_id,
//            'partner_id' => $request->brand,
////            'pdf' => $pdfPath
//        ]);


        return ['status' => 200, 'desc' => 'Product created successfully', 'data'=>  $request->all() ];
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
