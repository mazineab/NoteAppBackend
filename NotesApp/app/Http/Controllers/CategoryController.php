<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Exception;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CategoryController extends Controller
{
    public function createCategory(Request $request){
        try{
            $request->validate([
                "nameCat"=>"required",
            ]);
            Category::create([
                "user_id"=>auth()->user()->id,
                "nameCat"=>$request->nameCat,
            ]);
            return Response()->json([
                "status"=>true,
                "message"=>"category created successful"
            ]);
        }
        catch(Exception $e){
            return response()->json(['message' => 'Category creation failed', 'error' => $e->getMessage()], 500);
        }
    }

    public function getCategories(){
        try{
            $categories=Category::where("user_id",auth()->user()->id)->get();
            return $categories;
        }
        catch(Exception $e){
            return Response()->json([
                "status"=>false,
                "message"=>"faild load categories",
                "error"=>$e->getMessage()
            ]);
        }
    }

    public function deleteCategory($id){
        try{
            $hasCat=Category::where('id',$id)
                            ->where('user_id',auth()->user()->id)
                            ->first();
            if(!$hasCat){
                return Response()->json([
                    'status'=>false,
                    'message'=>'user not has this category'
                ]);
            }
            $categoory=Category::findOrFail($id);
            $categoory->delete();
            return Response()->json([
                'status'=>true,
                'message'=>"Category deleted successfully"
            ]);
        }
        catch(Exception $e){
            return Response()->json([
                'status'=>false,
                "error"=>$e->getMessage()
            ]);
        }
    }
}

