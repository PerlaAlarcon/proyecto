<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    //public function index()
    //{
    //    return "Hola desde el controlador";
    //}
    //public function index2()
    //{
    //    return "Hola desde el controlador2";
    //}
    //public function index()
    //{
    //   return response()->json('{"Hola mundo":"nose"}',200);
    //}
    //public function index()
    //{
     //   $user = new User();

    //    $user->name="Perla";
    //    $user->email="perla@gmail.com";
    //    return response()->json([$user],200);
    //}
    //public function index()
    //{
    //    $user = new User();

    //    $user->name="queso";
    //    $user->type="manchego";
    //    $user->email="queso@gmail.com";

    //    return response()->json([$user],200);
    //}
    public function index()
    {
       $user = User::all();
        return response()->json([$user],200);
    }

    public function createUser(Request $request)
    {
        $data = $request->json()->all();

        try{
            $user = User::create([
                "name" => $data["name"],
                "nickname" => $data["nickname"],
                "email" => $data["email"],
                "password" => Hash::make($data["password"]),
                "token" => str_random(60)
            ]);
    
            return response()->json($user, 201);
        }
        catch(\Illuminate\Database\QueryException $e){
            $respuesta = array("error" => $e->errorInfo,"codigo"=>500);
            return response()->json($respuesta, 500);
        }

    }
    public function getUser($id)
    {
        $user=User::find($id);

        return response()->json($user, 200);
    }
    public function deleteUser($id){

        $user=User::find($id);
        $user->delete();
        return response()->json(["deleted"],204);
    }
    public function updateUser(Request $request, $id)
    {
        $data = $request->json()->all();
        $user = User::find($id);

        $user->name=$data["name"];
        $user->nickname=$data["nickname"];
        $user->email=$data["email"];

        $user->save();

        return response()->json($user, 200);
    }
    public function login(Request $request){
        $data=$request->json()->all();

        $user=User::where(["nickname"=>$data["nickname"]])->first();
        if($user){
            if(hash::check($data["password"],$user->password)){
                return response()->json($user,200);
            }
            else{
                $respuesta = array('error'=>"El password es incorrecto",'codigo'=>404);
                return response()->json($respuesta,404);
            }
        }else{
            $respuesta=array('error'=>"El usuario no existe",'codigo'=>404);
            return response()->json($respuesta,404);
        }
    }
    public function datos(Request $request){   
        $data=$request->json()->all();

        $result = DB::select('SELECT*FROM users where nickname = :nickname', ["nickname"=>$data["nickname"]]);

        return response()->json($result, 200);
        //

}

}