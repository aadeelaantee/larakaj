<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use App\Forms\Admin\Users\EditForm;
use App\Forms\Admin\Users\PasswordForm;
use App\Models\User;
use App\Models\LangCode;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $data = [];

        $data['title'] = __('Users');
        $data['rows'] =  $rows = User::orderByDesc('id')->get();
        
        return view('admin.user.index', $data);
    }

    public function edit(Request $request, FormBuilder $formBuilder, LangCode $langCode, User $user)
    {
        $data = [];

        $data['title'] = __('Edit user');
        $data['row'] = $user;
        $data['form'] = $formBuilder->create(EditForm::class, [
            'method' => 'patch',
            'url' => route('admin.users.update', ['user' => $user]),
            'model' => $user,
        ]);

        $data['navigation'] = [
            [
                __('Users'),
                route('admin.users.index'),
            ],
            [
                __('Change user password') . ' ' . $user->username,
                route('admin.users.password', ['user' => $user]),
            ]
        ];

        return view('admin.user.edit', $data);
    }

    public function update(Request $request, LangCode $langCode, User $user)
    {
        $validated = $request->validate([
            'name'      => 'required|min:2',
            'email'     => 'required|email',
            'twitter'   => 'nullable|min:5',
            'facebook'  => 'nullable|min:5',
            'linkedin'  => 'nullable|min:5',
            'instagram' => 'nullable|min:5',
            'github'    => 'nullable|min:5',
            'youtube'   => 'nullable|min:5',
            'about'     => 'nullable|min:2',
            'active'    => 'required|boolean',
        ]);

        $user->name      = $validated['name'];
        $user->email     = $validated['email'];
        $user->twitter   = $validated['twitter'];
        $user->facebook  = $validated['facebook'];
        $user->linkedin  = $validated['linkedin'];
        $user->instagram = $validated['instagram'];
        $user->github    = $validated['github'];
        $user->youtube   = $validated['youtube'];
        $user->about     = $validated['about'];
        $user->active    = (bool) $validated['active'];

        $user->save();

        return back()->with('messages', [
            ['success', __('User editted successfully.')],
        ]);
    }


    public function password(Request $request, FormBuilder $formBuilder, LangCode $langCode, User $user)
    {
        $data = [];
        $data['title'] = __('Change user password') . ' ' . $user->username;
        $data['form'] = $formBuilder->create(PasswordForm::class, [
            'url' => route('admin.users.update_password', ['user' => $user]),
            'method' => 'patch',
        ]);

        $data['navigation'] = [
            [
                __('Users'),
                route('admin.users.index'),
            ],
            [
                __('Edit user') . ' ' . $user->username,
                route('admin.users.edit', ['user' => $user]),
            ],
        ];

        return view('admin.user.password', $data);
    }

    public function updatePassword(Request $request, LangCode $langCode, User $user)
    {
        $validated = $request->validate([
            'password' => 'required|min:5|confirmed',
        ]);

        $user->password = bcrypt($validated['password']);
        $user->save();

        return back()->with('messages', [
            ['success', __('Password changed successfully.')],
        ]);
    }
}
