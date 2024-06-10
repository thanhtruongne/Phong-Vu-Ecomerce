<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Authencate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class AuthencateController extends Controller
{
    public function index(Request $request) {
          if(Auth::id() !== null) {
            return redirect()->back();  
        }
        return view('backend.auth.login');
    }

    public function login(Authencate $request) {

        if (Auth::attempt(['email' => $request->input('email'),'password' => $request->input('password')])) {
            $request->session()->regenerate();
            return redirect()->route('private-system.dashboard')->with('success','Đăng nhập thành công');
        }

        return redirect()->back()->with('error','Email hoặc mật khẩu không đúng');
    }

    public function logout(Request $request) {
        
        Auth::logout();
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect()->route('private.system.login');
    }
}
