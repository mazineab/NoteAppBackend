<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Exception;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function createNote(Request $request){
        try{
            $request->validate([
                "category_id"=>"required",
                "name"=>"required",
                "content"=>"required",
            ]);
            Note::create([
                "category_id"=>$request->category_id,
                "name"=>$request->name,
                "content"=>$request->content
            ]);
            return Response()->json([
                "status"=>true,
                "message"=>"Note created successful"
            ]);
        }
        catch(Exception $e) {
            return Response()->json([
                "status"=>true,
                "message"=>"faild creation note",
                "error"=>$e->getMessage(),
            ]);
        }
    }

    public function getNotes(Request $request){
        try{
            $request->validate([
                'category_id'=>"required",
            ]);
            $notes=Note::where("category_id",$request->category_id)->get();
            return $notes;
        }
        catch(Exception $e){
            return Response()->json([
                "status"=>false,
                "message"=>"faild load categories",
                "error"=>$e->getMessage()
            ]);
        }
    }
}
