<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class userController extends Controller
{
    public function user(){
        return Auth::user();
    }
}
