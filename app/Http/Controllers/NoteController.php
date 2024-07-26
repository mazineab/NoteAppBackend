<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Note;
use Exception;
use GuzzleHttp\Psr7\Response;
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
            $category = Category::where('id', $request->category_id)
                                ->where('user_id', auth()->user()->id)
                                ->first();
            if(!$category){
                return response()->json([
                    "status" => false,
                    "message" => "Category does not belong to the authenticated user",
                ], 403);
            }
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
            $category=Category::where("id",$request->category_id)
                                ->where("user_id",auth()->user()->id)
                                ->first();
            if(!$category){
                return Response()->json([
                    'status'=>false,
                    'error'=>"Category does not belong to the authenticated user"
                ],403);
            }
            $notes=Note::where("category_id",$request->category_id)->get();
            return $notes;
        }
        catch(Exception $e){
            return Response()->json([
                "status"=>false,
                "message"=>"faild load Notes",
                "error"=>$e->getMessage()
            ]);
        }
    }

    public function deleteNote($id){
        try{
            $note=Note::findOrFail($id);
            $category=Category::where('id',$note->category_id)
                              ->where('user_id',auth()->user()->id)
                              ->first();
            if(!$category){
                return Response()->json([
                    'status'=>false,
                    'error'=>"you don't has this note"
                ],403);
            }
            $note->delete();
            return response()->json([
                'status' => true,
                'message' => 'Note deleted successfully',
            ], 200);
        }
        catch(Exception $e){
            return Response()->json([
                'status'=>false,
                'error'=>$e->getMessage(),
            ]);
        }
    }

    public function editNote(Request $request){

        try{
            $request->validate([
                'note_id'=>"required",
                ''
            ]);
            $note=Note::findOrFail($id);
            $category=Category::where('id',$note->category_id)
                              ->where('user_id',auth()->user()->id)
                              ->first();
            if(!$category){
                return Response()->json([
                    'status'=>false,
                    'error'=>"you don't has this note"
                ],403);
            }
            $note->update([
                'title' => $request->input('title'),
                'content' => $request->input('content'),
                'category_id' => $request->input('category_id')
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Note edit successfully',
            ], 200);

        }catch(Exception $e){
            return Response()->json([
                'status'=>false,
                'error'=>$e->getMessage(),
            ]);
        }
    }
}
