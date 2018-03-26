<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //
    public function index()
    {
        $posts = Post::orderBy("created_at","desc")->paginate(6);
        return view("post/index",compact("posts"));
    }

    public function show()
    {
        return view("post/show");

    }

    public function create()
    {
        return view("post/create");
    }

    public function store()
    {
        $post = new Post();
        $post->title = "一";
        $post->content = "一yiyiyiyi";
        $post->save();
    }

    public function edit()
    {
        return view("post/edit");

    }

    public function update()
    {

    }

    public function delete()
    {

    }



}
