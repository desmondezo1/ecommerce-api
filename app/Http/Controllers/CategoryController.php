<?php

namespace App\Http\Controllers;

use App\Models\category;
use Illuminate\Http\Request;
use mysql_xdevapi\Exception;
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
//        $catArray = $this->getArray($categories->toArray());
        $catArray= [] ;
        $totalCat = count($categories);



        foreach ( $categories as &$cat){
            //parents
            if($cat->is_parent && !$cat->parent_id){
                $cat['children'] = category::find($cat->id)->children;
                $catArray[] = $cat;
            }
            //base
            if(!$cat->is_parent && !$cat->parent_id){
                if(!in_array($cat, $catArray)){
                    $catArray[] = $cat;
                }
            }
        }

//        foreach ( $categories as &$cat){
//            if($cat->is_parent !== 1 && $cat->parent_id !== null){
//                if(!in_array($cat, $catArray)){
//                    $catArray[] = $cat;
//                }
//            }
//        }

//        function getChildren($arrayPa, $result = []){
//            //base case
//            //if array has no parents return
//            foreach ($arrayPa  as $arr){
//                in_array('is_parent');
//                if ($arr)
//            }

//            if(!is_array($arrayPa) || empty($arrayPa)){
//                echo "empty";
//                return $result;
//            }
//
//            $last = $arrayPa[count($arrayPa) - 1];
//            if($last->is_parent !== 1){
//                echo "checks";
//                $result[] = $last;
////                array_pop($arrayPa);
////                getChildren($arrayPa, $result);
//            }else{
//                echo "children";
//                $last['children'] = category::find($last->id)->children;
//                if(!is_array($last['children'])) {
//                    foreach ($last['children'] as &$child) {
//                        if($child->is_parent !== 1){
//                            $child['children'] = category::find($child->id)->children;
//                        }
//
//                    }
//                }
////                $result[] = $last;
//                array_pop($arrayPa);
//                getChildren($arrayPa, $result);
//            }

//        }
//
//
        foreach ($catArray as &$cat){
            if($cat->children){
                foreach ($cat->children as &$c){
                    if($c->is_parent){
                        $c['children'] = category::find($c->id)->children;
                        foreach ($c['children'] as &$secChild){
                            if($secChild->is_parent){
                                $secChild['children'] =  category::find($secChild->id)->children;
                            }
                        }
                    }
                }
            }
        }


//        $vals =[];
//        foreach ( $categories as $cat){
//            if(!$cat->is_parent && $cat->parent_id){
////                echo "catarray ".count($catArray);
//                $vals[] = $cat;
////                $v = self::findItemRecursive($catArray, $cat, []);
//            }
//        }
//        $v = [];
//        for ($i = 0, $i < count($vals); $i++;){
//            $v[] = self::findItemRecursive($catArray, $vals[$i]);
//        }

//        echo count($vals);
//
//        function findItemRecursive($arr, $item){
//            if (count($arr) <= 0){
//                return $arr;
//            }
//
//            $res = [];
//            foreach ( $arr as &$rr){
//                if ($item['parent_id'] == $rr['id']){
//                    $rr['children'] = $item;
//                    $res[] = $arr;
//                }else{
//                    if (in_array('children', $rr)){
//                        if( is_array($rr['children']) || is_object($rr['children']) ){
//                            $res[] = findItemRecursive($rr['children']);
//                        }
//                    }
//                }
//            }
//
//            return $res;
//        }


//        $v = getChildren( $catArray);
//        $v = getChildren( $categories);




        return ['status'=> 200, 'desc' => 'categories fetched successfully ', 'data' => $catArray,];
//        return ['status'=> 200, 'desc' => 'categories fetched successfully ', 'data' => $res];
//        return ['status'=> 200, 'desc' => 'categories fetched successfully ', 'v'=> $v ];
//        return ['status'=> 200, 'desc' => 'categories fetched successfully ', 'data' => $categories];

    }

//
//    public function getArray($categories, $catArray = []){
////        $categories = (array)$categories;
//        if(empty($categories)){
//            if(empty($catArray)){
//                return [];
//            }
//            return $catArray;
//        }
//
////        foreach ( $categories as &$cat){
//        for ($i=0; $i < count($categories); $i++){
//            if($categories[$i]['is_parent'] == 1 && !isset($categories[$i]['parent_id'])){
//                $categories[$i]['children'] = category::find($categories[$i]->id)->children;
//                $catArray[] = $categories[$i];
//            }
//
//            print_r($categories[$i]['is_parent']);
//            if($categories[$i]['is_parent'] !== 1 && !isset($categories[$i]['parent_id'])){
//
//                if(!in_array($categories[$i], $catArray)){
//                    $catArray[] = $categories[$i];
//                }
//            }
//        }
//
////        foreach ($catArray as &$cat){
////            if($cat['children']){
////                foreach ($cat['children'] as &$c){
////
////                    if($c['is_parent'] == 1){
////                        $c['children'] = category::find($c->id)->children;
////                    }
////                }
////            }
////        }
//        echo "here";
//
//        array_pop($categories);
//        return $this->getArray($categories, $catArray);
//
//    }

    public static function findItemRecursive($arr, $item, $res = []){
        if (count($arr) <= 0 || empty($item)){
            echo count($arr);
            echo "exits";
            return $res;
        }

            $rr = $arr[count($arr) -1];
//        foreach ( $arr as &$rr){
            if ($item->parent_id === $rr->id){
                echo "parenzt equals";
                $rr['children'] = $item;
//                $res[] = $arr;
                print_r(['id' => $rr->id, "parent" => $rr->parent_id]);
                print_r(['item-id' => $item->id, "item-parent" => $item->parent_id]);
                return $rr;
            }else{
                if (in_array('children',  $rr->toArray())){
                    if( is_array($rr['children']) || is_object($rr['children']) ){
                        echo "recurs here ";
                        $res[] = self::findItemRecursive($rr['children']);
                        return $res;
                    }
                }
//            }
        }
        array_pop($arr);
        return self::findItemRecursive($arr, $item);
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
//            'is_parent' => ['required','Boolean'],
            'status' => ['required','String']
        ]);

        $payload = [
            'title' => $request->title,
            'photo' => $request->photo,
            'slug' => $request->slug,
            'summary' => $request->summary,
//            'parent_id' => $request->parent_id,
            'is_parent' => $request->is_parent,
            'status' => $request->status
        ];
//
        if (isset($request->parent_id) && $request->parent_id !== ''){
            $parent_category = category::find($request->parent_id);
            if (is_null($parent_category)){
                return ['status' => 500, 'desc' => 'Parent id not found', 'data'=> null];
            }
            $payload['parent_id'] = (int)$request->parent_id;
            $parent_category->is_parent = 1;
            $parent_category->save();
        }




        $category = Category::create($payload);

        return ['status'=> 200, 'desc' => 'category created successfully ', 'data' => $category];
//        return ['status'=> 200, 'desc' => 'category created successfully ', 'data' => $request->all()];

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
