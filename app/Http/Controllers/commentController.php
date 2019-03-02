<?php

namespace App\Http\Controllers;

use App\comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class commentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }
    public function createComment(Request $request){

        $data = $request->json()->all();

        try{
            $comment = comment::create(
                [
                    "body" => $data["body"],
                    "imagen_url" => $data["imagen_url"],
                    "user_id" => $data["user_id"],
                    "post_id" => $data["post_id"]
                ]);
    
                return response()->json([$comment],201);

        }catch(\Illuminate\Database\QueryException $e){
            $respuesta = array("error" => $e->errorInfo,"codigo"=>500);
            return response()->json($respuesta,500);
        }
    }
    public function getComment(){
        $comment = Comment::all();
        return response()->json([$comment],200);
    }
    Public function getCommentByID($id){
        $comment = Comment::find($id);
        return response()->json($comment, 200);
    }
    public function getCommentByUserID($id){
        $comment = Comment::where(["user_id" => $id])->get();
        return response()->json($comment, 200);
    }
    public function getCommentByPostID($id){
        $comment = Comment::where(["post_id" => $id])->get();
        return response()->json($comment, 200);
    }
    public function updateComment(Request $request, $id){
        $data = $request->json()->all();
        $comment = Comment::find($id);

        $comment->body = $data["body"];

        $comment->save();

        return response()->json($comment, 200);
    }
    public function deleteComment($id){
        try{
            $deleted = DB::delete('delete from comments where id = ?',[$id]);
            return response()->json("el commentario se ha eliminado correctamente", 200);

        }catch(\Illuminate\Database\QueryException $e){
            $respuesta = array("error"=>$e->errorInfo,"codigo"=>500);
            return response()->json($respuesta,500);
        }
    }
}
