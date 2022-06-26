<?php

namespace App\Http\Controllers;

use App\Models\partner;
use App\Models\product;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $brands = partner::all();
         return ['status' => 200, 'desc' => 'Products fetched successfully', 'data'=> $brands ];
    }

    public function adminIndex(){
        $brands = partner::all();
        foreach ( $brands as &$brand){
            $brand['count'] = product::where('brand_id', $brand->id)->count();
        }
        return ['status' => 200, 'desc' => 'Products fetched successfully', 'data'=> $brands ];

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

            $payload = [
            'name' => $request->name,
            ];

        try{


            if ($request->hasFile('photo')) {
                $original_filename = $request->file('photo')->getClientOriginalName();
                $original_filename_arr = explode('.', $original_filename);
                $file_ext = end($original_filename_arr);
                $destination_path = 'public/uploads/brands/';
                $image = 'U-' . time() . '.' . $file_ext;

                if ($request->file('photo')->move($destination_path, $image)) {
                    $payload['photo'] = url('/') . '/public/public/uploads/brands/' . $image;
                } else {
                    return $this->responseRequestError('Cannot upload file');
                }
            }

//            if ($request->hasFile('photo')) {
//                $original_filename = $request->file('photo')->getClientOriginalName();
//                $original_filename_arr = explode('.', $original_filename);
//                $file_ext = end($original_filename_arr);
//                $destination_path = 'public/uploads/brand/';
//                $image = 'U-' . time() . '.' . $file_ext;
//
//                if ($request->file('photo')->move($destination_path, $image)) {
//                    $payload['photo'] = url('/').'/public/uploads/brand/' . $image;
//                } else {
//                    return $this->responseRequestError('Cannot upload file');
//                }
//            } else {
//                return $this->responseRequestError('File not found');
//            }

        }

        catch(\Exception $e)
        {
            echo $e->getMessage();
        }
        $brand = partner::create($payload);
        return ['status' => 200, 'desc' => 'Brand created successfully', 'data'=>  $brand];
//        return ['status' => 200, 'desc' => 'Brand created successfully', 'data'=>  $request->all()];
//        return ['status' => 200, 'desc' => 'Brand created successfully', 'data'=>  $request->file('photo')];


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
     * @param  \App\Models\partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function show(partner $partner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function edit(partner $partner)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, partner $partner)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $brand = partner::destroy($id);

        if (!$brand){
            return ['status' => 500, 'desc' => 'Brand Item was not deleted' ];
        }

        return ['status' => 200, 'desc' => 'Brand has been deleted successfully' ];

    }
}
