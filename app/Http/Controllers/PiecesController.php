<?php

namespace App\Http\Controllers;

use App\Models\Pieces;
use Illuminate\Http\Request;

class PiecesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($piece)
    {
        $validatedData = $this->validate($piece,[
            'title' => ['required','unique:Products,title'],
//            'price' => 'required',
            'description' => 'required',
        ]);

        $product = Pieces::create([
            'title' => $piece->title,
            'price' => $piece->price,
            'description' => $piece->description,
            'offer_price' => $piece->offer_price,
            'photo' => $piece,
            'discount' => $piece->discount,
            'status' => $piece->status,
            'category_id' => $piece->category_id,
            'partner_id' => $piece->brand,
//            'pdf' => $pdfPath
        ]);

        return ['status' => 200, 'desc' => 'Product created successfully', 'data'=> $product ];
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
     * @param  \App\Models\Pieces  $pieces
     * @return \Illuminate\Http\Response
     */
    public function show(piecesController $pieces)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pieces  $pieces
     * @return \Illuminate\Http\Response
     */
    public function edit(piecesController $pieces)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pieces  $pieces
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, piecesController $pieces)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pieces  $pieces
     * @return \Illuminate\Http\Response
     */
    public function destroy(piecesController $pieces)
    {
        //
    }
}
