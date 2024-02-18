<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login() {
        return view('login');
    }
    public function loginvalidate(Request  $request) {

         $validated = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $emailormobile = $request->email;

        $credentialsemail = array("email" => $emailormobile, "password" => $request->password);


        if ((Auth::attempt($credentialsemail))) {

            $user = Auth::user();
            return redirect()->route('dashboard');
        }
         else {
            return back()->with('fail', 'Wrong credentials');
        }
    }

    public  function logout(){
        Auth::logout();
        return redirect()->route('login');
    }
}
