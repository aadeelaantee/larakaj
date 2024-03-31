<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use App\Models\User;
use App\Models\LangCode;

class PasswordController extends Controller
{
    public function forget(Request $request)
    {
        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'email' => 'required|email',
            ]);

            $status = Password::sendResetLink(['email' => $validated['email']]);
            return $status == Password::RESET_LINK_SENT
                ? back()->with('messages', [['success', __($status)]])
                : back()->withErrors(['email' => __($status)]);
        }

        $data = [];
        $data['title'] = __('Forget password');

        return view('password.forget', $data);
    }

    public function reset(Request $request, LangCode $langCode, string $token, string $email)
    {    
        if ($request->isMethod('post')) {            
            $validator = Validator::make($request->all(), [
                'token' => 'required',
                'email' => 'required|email',
                'password' => 'required|min:4|confirmed',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator);
            }

            $status = Password::reset(
                $validator->safe()->only(['email', 'password', 'token']),
                function (User $user, string $password) {
                    $user->forceFill([
                        'password' => Hash::make($password),
                    ])->setRememberToken(Str::random(60));
                    $user->save();

                    event(new PasswordReset($user));
                }
            );

            return $status == Password::PASSWORD_RESET
                ? redirect()->route('login')->with('messages', [['success', __($status)]])
                : back()->withErrors(['email' => __($status)]);
        }

        $data = [];
        $data['title'] = __('Reset password');
        $data['email'] = $email;
        $data['token'] = $token;

        return view('password.reset', $data);
    }
}
