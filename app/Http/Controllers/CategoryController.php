<?php

namespace App\Http\Controllers;

use App\Models\category;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isNull;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        Fix issues here


        $categories = category::where('status','published')->get();
        $catArray = [];
        $totalCat = count($categories);
        echo $totalCat;
        for($i = 0; $i < $totalCat; $i++){
            if ($categories[$i]->is_parent && is_null($categories[$i]->parent_id)){
                $categories[$i]['children'] = category::find($categories[$i]->id)->children;
                array_push($catArray, $categories[$i]);
            }

//            if (!is_null($categories[$i]->parent_id)){
                array_push($catArray, $categories[$i]);
//            }
        }

        return ['status'=> 200, 'desc' => 'categories fetched successfully ', 'data' => $catArray];

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->validate($request,[
            'title' => ['required','unique:categories,title'],
            'photo' => ['String'],
            'slug' => ['String'],
            'summary' => ['String'],
            'parent_id' => ['Numeric'],
            'is_parent' => ['required','Boolean'],
            'status' => ['required','String']
        ]);

        if (isset($request->parent_id)){
            $parent_category = category::find($request->parent_id);
            if (is_null($parent_category)){
                return ['status' => 500, 'desc' => 'Parent id not found', 'data'=> null];
            }
            $parent_category->is_parent = 1;
            $parent_category->save();
        }

        $category = Category::create([
            'title' => $request->title,
            'photo' => $request->photo,
            'slug' => $request->slug,
            'summary' => $request->summary,
            'parent_id' => $request->parent_id,
            'is_parent' => $request->is_parent,
            'status' => $request->status
        ]);

        return ['status'=> 200, 'desc' => 'category created successfully ', 'data' => $category];

    }

    public function edit(category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'title' => ['unique:categories,title'],
            'photo' => ['String'],
            'slug' => ['String'],
            'summary' => ['String'],
            'parent_id' => ['Numeric'],
            'is_parent' => ['Boolean'],
            'status' => ['String']
        ]);

        $category =  category::find($id);
        isset($request->title) ? $category->title = $request->title: false;
        isset($request->photo) ? $category->photo = $request->photo: false;
        isset($request->slug) ? $category->slug = $request->slug: false;
        isset($request->summary) ? $category->summary = $request->summary: false;
        isset($request->parent_id) ? $category->parent_id = $request->parent_id: false;
        isset($request->is_parent) ? $category->is_parent = $request->is_parent: false;
        isset($request->status) ? $category->status = $request->status: false;
        $category->save();

        return ['status'=> 200, 'desc' => 'category created successfully ', 'data' => $category];

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = category::find($id);
        if (is_null($category)){
            return ['status'=> 500, 'desc' => 'Category doesn\'t exist ', 'data' => $category];
        }
        if ( $category->is_parent == 1){
            $children = category::where('parent_id', $id)->get();
            foreach($children as $child){
                $child->parent_id = null;
                $child->save();
            }
        }
        $category->destroy($id);
        return ['status'=> 200, 'desc' => 'category Deleted successfully ', 'data' => $category];
    }

}
