<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class LoginController extends Controller
{
    public function index()
    {
        //bat dau truyen thong tin qua view
        return view('admin.users.login',[
            'title' => 'System Login for admin',
        ]);
    }

    public function store(Request $request)
    {
        //Luu tru thong tin qua view
        //validate form admin email,password
        $this->validate($request, [
            'email' => 'required|email:filter',
            'password' => 'required'
        ]);
        //kiem tra dk
        if (Auth::attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ], $request->input('remember') )){
            return redirect()->route('admin');
        }
        //hien thi thong bao login
        Session::flash('error', 'Email hoặc Password không đúng vui lòng nhập lại!');
        return redirect()->back();

    }
}
