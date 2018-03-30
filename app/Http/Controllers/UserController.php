<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {

    }

    public function show(User $user)
    {
        $posts = $user->posts()->get();
        $fans = $user->fans()->paginate(5);
        return view("user/show",compact("posts","user","fans"));
    }
}
