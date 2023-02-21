<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class User extends Controller
{
    //
   function showUsers($name){
    return "Hello From Controller".$name;
    }
}
