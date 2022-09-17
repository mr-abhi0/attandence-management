

<?php
/*
* Workday - A time clock application for employees
* Email: official.codefactor@gmail.com
* Version: 1.1
* Author: Brian Luna
* Copyright 2020 Codefactor
*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class profileController extends Controller
{
    public function viewProfile($userId = null)
    {
        $user = null;

        if ($userId != null) {
            $user = User::find($userId);
        } else {
            $user = User::find(Auth::user()->id);
        }

        return view('user/profile', [
            'user' => $user
        ]);
    }
}
