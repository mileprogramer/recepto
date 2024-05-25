<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            "email" => "string|min:3|unique:user,email",
            "first_name" => "string|min:3",
            "last_name" => "string|min:3",
            "password" => "string|min:5"
        ]);
        $password = Hash::make($request->input('password'));
        $is_inserted = DB::select("CALL register_new_user(:email, :password, :first_name, :last_name)", [
            "email"=> $request->input("email"),
            "password"=> $password,
            "first_name"=> $request->input("first_name"),
            "last_name"=> $request->input("last_name"),
        ]);
        if(empty($is_inserted))
        {
            return redirect("/register")->withErrors(["mistake"=>"So"]);
        }
        return view("register.register_page", ["success"=>"You successfully register"]);
    }

    public function create()
    {
        return view("register.register_page");
    }
}
