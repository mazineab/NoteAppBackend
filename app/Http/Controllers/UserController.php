<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function createUser(Request $request){
        try{
            $request->validate([
                "name"=>"required|string",
                "email"=>"required|unique:users,email",
                "phoneNumber"=>"required",
                "password"=>"required|string|min:8"
            ]);
            $user=User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'phoneNumber'=>$request->phoneNumber,
                'password'=>bcrypt($request->password),

            ]);
            return response()->json(['user'=>$user],201);
        }
        catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'User creation failed', 'error' => $e->getMessage()], 500);
        }
    }

    public function loginUser(Request $request){
        try{
            $request->validate([
                "email"=>"required|email",
                "password"=>"required|min:8"
            ]);
            if(!Auth::attempt($request->only(['email','password']))){
                return Response()->json([
                    'status'=>false,
                    'message'=>"email or password not correct",
                ],401);
            }
            $user=User::where("email",$request->email)->first();
            return Response()->json([
                'status'=>true,
                'user'=>$user,
                'token'=>$user->createToken("API TOKEN")->plainTextToken
            ],200);
        }
        catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'User creation failed', 'error' => $e->getMessage()], 500);
        }
    }

    public function logout(Request $request){
        $user=$request->user();
        if($user){
            $user->currentAccessToken()->delete();
           return response()->json([
            "status"=>true,
            "message"=>"Logout successful",
           ],200) ;
        }
    }

    public function getUser(Request $request){
        return $request->user();
    }

    
}
