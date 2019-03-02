<?php

namespace App\Http\Controllers;

use App\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class likeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {

    // }
    //public function like(Request $request,$id)
    //{
    //   $data=$request->json()->all();
    //    $like=like::find($id);

    //    $like->post_id=$data["post_id"];
    //    $like->comment_id=$data["comment_id"];
    //    $like->user_id=$data["user_id"];

    //    $like->save();

    //    return response()->json($like, 200);
    //}
    public function createLike(Request $request){
        $data = $request->json()->all();

        try{
            $like = Like::create([

                "post_id" => $data["post_id"],
                "comment_id" => $data["comment_id"],
                "user_id" => $data["user_id"],
            ]);
            return response()->json([$like],201);

        }catch(\Illuminate\Database\QueryException $e){
            $respuesta = array("error" => $e->errorInfo,"codigo" => 500);
            return response()->json($respuesta, 500);
        }
    }
    public function getLike(){
        $like = Like::all();
        return response()->json([$like],200);
    }
    Public function getLikeByID($id){
        $like = like::find($id);
        return response()->json($like, 200);
    }
    public function getLikeByUserID($id){
        $like = Like::where(["user_id" => $id])->get();
        return response()->json($like, 200);
    }
    public function getLikeByCommentID($id){
        $like = like::where(["comment_id" => $id])->get();
        return response()->json($like, 200);
    }
    public function deleteLike($id){
        try{
            $deleted = DB::delete('delete from likes where id = ?',[$id]);
            return response()->json("el like se ha eliminado correctamente", 200);

        }catch(\Illuminate\Database\QueryException $e){
            $respuesta = array("error"=>$e->errorInfo,"codigo"=>500);
            return response()->json($respuesta,500);
        }
    }
}