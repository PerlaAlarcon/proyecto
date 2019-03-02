<?php

namespace App\Http\Controllers;

use App\post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class PostController extends Controller
{
    public function index(){
        $post = new Post();
        $Post->title = "Hola mundo";
        $post->body = "cuerpo del post";
        $post->imagen_url="http://google.com";
        $post->user_id = 5;

        return response()->json($post, 200);
    }
    public function createPost(request $request){
        $data = $request->json()->all();
        $post = Post::create(
            [
                "title"=>$data["title"],
                "body"=>$data["body"],
                "imagen_url"=>$data["imagen_url"],
                "user_id"=>$data["user_id"]

            ]);
            return response()->json([$post],201);
    }
    public function getPosts(){
        $posts = Post::all();
        return response()->json([$posts],200);
    }
    public function getPostByID($id){
        $post = Post::all($id);
        return response()->json($post,200);
    }
    public function getPostByUserID($id){
        $post = Post::where(["user_id"=> $id])->get();
        return response()->json($post, 200);
    }
    public function updatePost(Request $reques, $id){

        $data = $request->json()->all();
        $post = post::find($id);


        $post->title = $data["title"];
        $post->body = $data["body"];

        $post->save();

        Return response()->json($post, 200);
    }
    public function deletePost($id){
        try{
            $deleted=DB::delete('detele from posts where id = ?',[$id]);
            return response()->json("Post borrado correctamente",200);

        }catch(Ulluminate\Database\QueryException $e){
            $respuesta = array("error"=>$e->errorInfo,"codigo"=>500);
            return response()->json($respuesta,500);
        }
    }
    public function uploadFile(Request $request){

        try{
            $destinationPath = "/Cliente-servidor/proyecto/storage/images";

            $fileName=str_random(10).".jpg";
            $request->file('imagen')->move($destinationPath, $fileName);
        }catch(\Illuminate\Database\QueryException $e){
            $respuesta = array("error"=>$e->errorInfo,"codigo"=>500);
            return response()->json($respuesta,500);
        }
    }
}