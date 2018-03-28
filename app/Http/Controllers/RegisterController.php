<?php

namespace App\Http\Controllers;



use App\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function index()
    {
        return view("register/index");

    }

    public function register()
    {
        $validator = \Validator::make(request()->input(),[
            'name' => "required|min:2|unique:users,name",
            'email' => "required|email|unique:users,email",
            'password' => "required|confirmed",
        ],[
            "name" => "用户名",
            "email" => "邮箱",
            "password" => "密码",
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::create(request(['name',"email","password"]));
        dd($user);
    }


}
