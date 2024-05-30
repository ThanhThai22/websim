<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Customer;
use Hash;


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
            ,'level' => 'admin' //neu them vao database truong level neu level = 1 redirect toi giao dien admin nguoc lai redirect giao dien kh
        ], $request->input('remember') )){
            Session::flash('success', 'Đăng nhập tài khoản quản trị thành công');

            return redirect()->route('admin');
        }

        if(Auth::attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password')
            ,'level' => 'customer' //neu them vao database truong level neu level = 1 redirect toi giao dien admin nguoc lai redirect giao dien kh
        ], $request->input('remember') )){
            Session::flash('success', 'Đăng nhập tài khoản thành công');
            return redirect()->route('index');
        }

        //hien thi thong bao login
        Session::flash('error', 'Email hoặc Password không đúng vui lòng nhập lại!');
        return redirect()->back();

    }

    public function indexRegister()
    {
        return view('admin.users.register',[
            'title' => 'Register Account VNPT',
        ]);
    }

    public function registerPost(Request $req)
    {
        $req->merge(['password' => Hash::make($req->password)]);
        try {
            User::create($req->all());
            Session::flash('success', 'Đăng ký tài khoản thành công :)');
            return \redirect()->route('login');
        } catch (\Throwable $th) {
            Session::flash('error', 'Đăng ký tài khoản thất bại :('. $th->getMessage());
        }
        return \redirect()->back();
    }

    public function logout()
    {
        Auth::logout();
        return \redirect()->back();
    }


}
