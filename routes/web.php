<?php
//用户模块
Route::get("register","RegisterController@index");
Route::post("register","RegisterController@register");

Route::get("login","LoginController@index");
Route::post("login","LoginController@login");
Route::get("logout","LoginController@logout");

Route::get("user/me/setting","UserController@index");




//获取文章列表
Route::get("posts","PostController@index");
//文章详情
Route::get("posts/{post}","PostController@show")->where('post', '[0-9]+');
//增加文章
Route::get("posts/create","PostController@create");
Route::post("posts","PostController@store");
//修改文章
Route::get("posts/{post}/edit","PostController@edit");
Route::put("posts/{post}","PostController@update");
//删除文章
Route::get("posts/{post}/delete","PostController@delete");
//图片上传
Route::post("posts/image/upload","PostController@imageUpload");