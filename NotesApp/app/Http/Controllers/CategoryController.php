<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Exception;
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
}
