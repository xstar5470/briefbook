<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        return view("login/index");

    }

    public function login()
    {
        $validator = \Validator::make(request()->input(),[
            "email" => "required|email",
            "password" => "required"
        ],[
            "email" => "邮箱",
            "password" => "密码"
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $userinfo = request(["email","password"]);
        $is_remember = boolval(request("is_remember"));
        $flag = \Auth::attempt($userinfo,$is_remember);

        if($flag){
            return redirect("/posts");
        }else{
            return redirect()->back()->withErrors("邮箱密码不匹配");
        }


    }

    public function logout()
    {
         \Auth::logout();
        return redirect("/login");

    }
}
