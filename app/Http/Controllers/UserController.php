<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function show() {
        return view('users.register');
    }

    public function store(Request $request) {
        $userStore = $request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => 'min:3|required_with:password_confirm|same:password_confirm',
            
        ]);

        // Hash Password
        $userStore['password'] = bcrypt($userStore['password']);

        // Create User
        $user = User::create($userStore);

        // Login
        auth()->login($user);

        return redirect('/')->with('message', 'User created and logged in');
    }

    public function logout(Request $request){
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerate();
        return redirect('/');
    
    }
    public function login() {
        return view('users.login');
    }

    public function authenticate(Request $request) {
        $login = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required',
        ]);
        if(auth()->attempt($login)){
                $request->session()->regenerate();
                return redirect('/')->with('message','Login Successfully');
        }
        return back()->withErrors(['email'=>'invalid login'])->onlyInput('email');
    }
}
