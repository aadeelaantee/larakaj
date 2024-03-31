<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'email' => 'required',
                'password' => 'required',
            ]);

            $remember_me = $request->boolean('remember_me');
           
            if ($validator->fails()) {
                return back()->withErrors($validator);
            }

            if (Auth::attempt($validator->safe()->only(['email', 'password']), $remember_me)) {
                $request->session()->regenerate();
                return redirect()->intended('/')->with('messages', [
                    ['success', __('Logged in successfully')],
                ]);
            }
            
            return back()->withErrors(['email' => __('Invalid email or password')]);            
        }

        $data = [];
        $data['title'] = __('Login');

        return view('auth.login', $data);
    }


    public function register(Request $request)
    {
        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'name' => 'required|min:3',
                'username' => 'required|min:3|unique:users',
                'email' => 'required|min:6|max:100|unique:users',
                'password' => 'required|min:4|confirmed',
            ]);

            $user = new User();
            $user->name = $validated['name'];
            $user->email = $validated['email'];
            $user->password = Hash::make($validated['password']);
            $user->save();

            event(new Registered($user));

            return redirect()->route('login')->with('messages', [    
                ['success', __('User registered successfully')],              
            ]);
        }

        $data = [];
        $data['title'] = __('Register');

        return view('auth.register', $data);
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return to_route('login')->with('messages', [
            ['success', __('Logged out successfully')],
        ]);
    }
}
