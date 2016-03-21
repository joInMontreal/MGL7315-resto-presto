<?php

namespace App\Http\Controllers;

use App\User;

class Home extends Controller
{
    public function welcome()
    {
        $users = User::all();
        return view('welcome', ['users' => $users]);
    }
}
