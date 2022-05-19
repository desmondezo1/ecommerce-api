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
        try{

            if ($request->hasFile('photo')) {
                $fileExtension = $request->file('photo')->getClientOriginalName();
                $file = pathinfo($fileExtension, PATHINFO_FILENAME);
                $extension = $request->file('photo')->getClientOriginalExtension();
                $fileStore = $file . '_' . time() . '.' . $extension;
                $photoPath = $request->file('photo')->move('public/photos/brandlogo', $fileStore);
            }

            $brand = partner::create([
                'name' => $request->name,
//                'photo' => $photoPath
            ]);

        }
        catch(\Exception $e)
        {
            echo $e->getMessage();
        }

//        return ['status' => 200, 'desc' => 'Brand created successfully', 'data'=> $request->all() ];
        return ['status' => 200, 'desc' => 'Brand created successfully', 'data'=> $brand ];

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
    public function destroy(partner $partner)
    {
        //
    }
}
