<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use App\Zan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class PostController extends Controller
{
    //首页文章列表
    public function index()
    {
        $posts = Post::orderBy("created_at","desc")->withCount("comments")->withCount("zans")->paginate(2);
        return view("post/index",compact("posts"));
    }

    public function show(Post $post)
    {
        $post->load("comments");
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
    //给文章添加评论
    public function comment(Post $post)
    {
        $validator = \Validator::make(request()->input(),[
            "content" => "required",
        ],[
            "content" => "评论内容"
        ]);
        //手动注册错误信息 数据保持等
        if( $validator->fails() ){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $comment = new Comment();
        $comment->user_id = \Auth::id();
        $comment->content = request("content");
        $post->comments()->save($comment);

        return back();
    }
    //点赞
    public function zan(Post $post)
    {
        $params = [
            "user_id" => \Auth::id(),
            "post_id" => $post->id
        ];
        
        Zan::firstOrCreate($params);
        return back();
    }
     //取消点赞
    public function unzan(Post $post)
    {
        $post->zan(\Auth::id())->delete();
        return back();
    }

    //搜索功能
    public function search(Request $request)
    {
        $validator = \Validator::make(request()->input(),[
            "keyword" => "required",
        ],[
            "keyword" => "关键字",
        ]);
        //手动注册错误信息 数据保持等

        if( $validator->fails() ){
            return redirect()->back()->withErrors($validator);
        }

        $keyword = request("keyword");
        $posts = Post::where('title','like','%'.$keyword.'%')->orWhere('content','like','%'.$keyword.'%')->paginate(2);


        return view("post/search",compact("posts","keyword"));

    }


}
