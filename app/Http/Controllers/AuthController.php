<?php

namespace App\Http\Controllers;
use Hash;
use Session;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;

class Authcontroller extends Controller
{


  
    public function index()
    {
        return view('auth.login');
    }  


    public function login(Request $request)
    {
      
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
     
        $credentials = $request->only('username', 'password');
        if (Auth::attempt($credentials)) {
                return redirect()->route('dashboard');
                  
        }
        return redirect("login")->withSuccess('Credenciales invalidas');
    }


   
    public function signOut() {
        Session::flush();
        Auth::logout();
  
        return Redirect('login');
    }
  
}
