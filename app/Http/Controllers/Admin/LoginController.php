<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index(){
        return view('admin.login');
    }
    public function login(Request $request){
        $validated = $request->validate([
            'username' => 'required|unique:posts|max:255',
            'password' => 'required',
            'verify' => 'required',
        ]);
        return ['code'=>1001,'msg'=>'登录失败'];
    }
}
