<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use App\Models\User;

class MainController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;
    public function show_login(){
        if (Auth::check()) {
            return redirect('/');
        }
        return view('auth.login');
    }
    public function login(Request $request){
        $user = User::where('email', $request->email)->first();


        if (empty($user)) {
            $userdata = array(
                'email'     => $request->email,
                'password'  => $request->password
            );
            if (Auth::attempt($userdata)) {
                return redirect('login');
            } else {
                return redirect()->back()->with('error_msg', 'Login Gagal');
            }
        } else {
            if (Auth::loginUsingId($user->id)) {
                return redirect('login');
            } else {
                return redirect()->back()->with('error_msg', 'Login gagal');
            }
        }
    }
}
