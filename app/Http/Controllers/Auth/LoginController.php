<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
   public function showLoginForm(){
       return view('auth.login');
   }

   public function login(Request $request){
       $this->validateLogin($request);

       if(Auth::attempt([
           'nickUsuarios'=>$request->nickUsuarios,
           'password'=>$request->password,
           ])){
            return redirect()->route('main');
        }
        return back()->withErrors(['nickUsuarios'=>trans('auth.failed')])
        ->withInput(request(['nickUsuarios']));
   }
   public function validateLogin(Request $request){
        $this->validate($request, [
        'nickUsuarios'=>'required|string',
        'password'=>'required|string',
    ]);
   }

   public function logout(Request $request){
       Auth::logout();
       $request->session()->invalidate();
       return redirect('/');
   }
}
