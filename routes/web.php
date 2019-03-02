<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});
$router->get('/hola', function(){
    return"ola k ace";
});



$router->get('/hola2',["uses"=>"UserController@index2"]);

$router->get('/key',function(){
    return str_random(32);
});
$router->post('/user', ["uses"=>"UserController@createUser"]);
//  $router->get('/users', ["uses"=>"UserController@getUser"]);
//  $router->delete('/user/{id}', ["uses"=>"UserController@deleteUser"]);

$router->group(['middleware'=>['auth']],function() use ($router){
    $router->get('/users',["uses"=>"UserController@index"]);
    $router->get('/user/{id}', ["uses"=>"UserController@getUser"]);
    $router->put('/user/{id}', ["uses"=>"UserController@updateUser"]);
});
    
$router->get('/login',["uses"=>"UserController@login"]);

$router->post('/datos', ["uses"=>"UserController@datos"]);

$router->post('/createUser', ["uses"=>"UserController@createUser"]);

$router->get('/post', ["uses"=>"PostController@post"]);

$router->post('/post', ["uses"=>"PostController@createPost"]);

$router->post('/posts', ["uses"=>"PostController@getPosts"]);

$router->put('/post/{id}', ["uses"=>"PostController@updatePost"]);

$router->post('/file', ["uses"=>"PostController@uploadFile"]);

//Comments

$router->post('/create',["uses"=>"commentController@createComment"]);

$router->get('/obtener',["uses"=>"commentController@getComment"]);

$router->get('/obtener/{id}',["uses"=>"commentController@getCommentByID"]);

$router->get('/ver/{user_id}',["uses"=>"commentController@getCommentByUserID"]);

$router->get('/verComment/{post_id}',["uses"=>"commentController@getCommentByPostID"]);

$router->put('/actualizar/{id}',["uses"=>"commentController@updateComment"]);

$router->delete('/eliminar/{id}',["uses"=>"commentController@deleteComment"]);

//likes

$router->post('/createLike',["uses"=>"likeController@createLike"]);

$router->get('/obtenerLike',["uses"=>"likeController@getLike"]);

$router->get('/obtenerLike/{id}',["uses"=>"likeController@getLikeByID"]);

$router->get('/obtenerLikeUser/{user_id}',["uses"=>"likeController@getLikeByUserID"]);

$router->get('/obtenerLikeComment/{comment_id}',["uses"=>"likeController@getLikeByCommentID"]);

$router->delete('/deleteLike/{id}',["uses"=>"likeController@deleteLike"]);