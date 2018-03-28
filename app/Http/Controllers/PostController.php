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

    public function show(Post $post)
    {
        return view("post/show",compact('post'));

    }

    public function create()
    {

        return view("post/create");
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->input(),[
            "title" => "required|string|min:2|max:20",
            "content" => "required|min:30",
        ],[
            "title" => "标题",
            "content" => "内容"
        ]);
        //手动注册错误信息 数据保持等
        if( $validator->fails() ){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $user_id = \Auth::id();

        $params = array_merge(request(['title','content']),compact("user_id"));

        Post::create($params);
        return redirect("/posts");
    }

    public function edit(Post $post)
    {
        return view("post/edit",compact('post'));
    }

    public function update(Post $post)
    {
        $this->authorize("update",$post);
        $validator = \Validator::make(request()->input(),[
            "title" => "required|string|min:2|max:20",
            "content" => "required|min:30",
        ],[
            "title" => "标题",
            "content" => "内容"
        ]);
        //手动注册错误信息 数据保持等
        if( $validator->fails() ){
             return redirect()->back()->withErrors($validator)->withInput();

        }

        $post->title = request('title');
        $post->content = request('content');
        $post->save();

        return redirect("/posts/$post->id");


    }

    public function delete(Post $post)
    {
        $post->delete();
        return redirect("/posts");

    }

    public function imageUpload(Request $request)
    {
        $path = $request->file('wangEditorH5File')->storePublicly(md5(time()));
        return asset("storage/".$path);


    }


}
