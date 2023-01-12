<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class CustomAuthController extends Controller
{
    public function index() {
        return View('auth.register');
    }

    public function store(RegisterRequest $request) {
        $data = $request->all();
        $name = $request->name;
        $result = $this->create($data);
        if($result) {
            return View('index', [
                'status' => 200,
                'message' => 'Register success',
                'name' => $name,
            ]);
        }
        return View('index', [
            'status' => 422,
            'message' => 'Register false'
        ]);

    }

    public function create(array $data) {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);
    }

    public function login() {
        return View('auth.login');
    }

    public function custom_login(Request $request) {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $name = Auth::user()->name;
            session()->put('name', $name);
            
            return View('index', [
                'status' => 200,
                'name' => $name,
            ]);
            
        }
        return redirect()->back()->with([
            'status' => 422,
            'message' => 'Email or password is incorrect',
        ]);
    }

    public function logout() {
        Session::flush();
        Auth::logout();
        return View('index');
    }
}
