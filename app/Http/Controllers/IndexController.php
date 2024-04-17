<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Models\Post;
use App\Models\User;
use App\Models\Tag;
use App\Models\Comment;
use App\Models\LangCode;
use App\Forms\Front\Index\CommentForm;
use App\Forms\Front\Index\ProfileForm;

class IndexController extends Controller
{
    public function index(Request $request, LangCode $langCode)
    {
        $data = [];
        $data['title'] = __('Home');        
        $data['rows'] = Post::whereShowInList(true)
            ->whereActive(true)
            ->whereLangCode($langCode->name)
            ->orderByDesc('id')
            ->get();

        return view('index.index', $data);
    }

    public function post(Request $request, FormBuilder $formBuilder, LangCode $langCode, Post $post)
    {
        $data = [];
        $data['title'] = $post->title;
        $data['row'] = $post;
        $data['commentForm'] = $formBuilder->create(CommentForm::class);

        return view('index.post', $data);
    }

    public function storeComment(Request $request, LangCode $langCode, Post $post)
    {
        $validator = Validator::make($request->all(), [
            'parent_id' => 'nullable|exists:comments,id',
            'name' => 'sometimes|required|min:2',
            'email' => 'sometimes|required|email',
            'comment' => 'required|min:5',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $validated = $validator->validated();

        $obj = new Comment();
        $obj->comment = $validated['comment'];
        $obj->post_id = $post->id;
        $obj->parent_id = $validated['parent_id'];
        $obj->active = false;

        if ($request->user())
            $obj->user_id = $request->user()->id;
        else {
            $obj->name = $validated['name'];
            $obj->email = $validated['email'];
        }

        $obj->save();
        return back()->with('messages', [
            ['success', __('Comment saved successfully.')],
        ]);
    }


    public function profile(Request $request, LangCode $langCode, User $user)
    {
        $data = [];
        $data['title'] = __('Profile');
        $data['user'] = $user;

        return view('index.profile', $data);
    }

    public function editProfile(Request $request, FormBuilder $formBuilder, LangCode $langCode, User $user)
    {
        $data = [];
        $data['title'] = __('Edit profile');
        $data['user'] = $user;
        $data['form'] = $formBuilder->create(ProfileForm::class, [
            'url' => route('update_profile', ['user' => $user]),
            'method' => 'patch',
            'model' => $user,
        ]);

        return view('index.edit_profile', $data);
    }

    public function updateProfile(Request $request, LangCode $langCode, User $user)
    {
        $validated = $request->validate([
            'name'        => 'required|min:2',
            'email'       => 'required|email',
            'twitter'     => 'nullable|min:5',
            'facebook'    => 'nullable|min:5',
            'linkedin'    => 'nullable|min:5',
            'instagram'   => 'nullable|min:5',
            'github'      => 'nullable|min:5',
            'youtube'     => 'nullable|min:5',
            'about'       => 'nullable|min:2',
            'image'       => 'nullable|image',
        ]);

        $user->name       = $validated['name'];
        $user->email      = $validated['email'];
        $user->twitter    = $validated['twitter'];
        $user->facebook   = $validated['facebook'];
        $user->linkedin   = $validated['linkedin'];
        $user->instagram  = $validated['instagram'];
        $user->github     = $validated['github'];
        $user->youtube    = $validated['youtube'];
        $user->about      = $validated['about'];
        $user->about_html = app('commonMark')->convert($user->about);

        //dd($validated);

        if (isset($validated['image'])) {            
            $image = $validated['image']->store('images/profile', 'public');

            /**
             * Delete Old image from disk.
             */
            if ($user->image)
                Storage::disk('public')->delete($user->image);

            $user->image = $image;
        }

        $user->save();

        return back()->with('messages', [
            ['success', __('User editted successfully.')],
        ]);
    }

    public function deleteProfileImage(Request $request, LangCode $langCode, User $user)
    {
        abort_if(! $user->image, 404);

        Storage::disk('public')->delete($user->image);

        $user->image = null;
        $user->save();

        return back()->with('messages', [
            ['success', __('Profile image deleted successfully.')],
        ]);
    }

    public function tag(Request $request, LangCode $langCode, Tag $tag)
    {
        $data = [];
        $data['title'] = $tag->name;
        $data['tag'] = $tag;
        $data['rows'] = $tag->posts()
            ->whereActive(true)
            ->whereLangCode($langCode->name)
            ->orderByDesc('id')
            ->get();

        return view('index.index', $data);
    }

    public function author(Request $request, LangCode $langCode, User $user)
    {
        $data = [];
        $data['title'] = __('Posts of') . ' ' . $user->name;
        $data['author'] = $user;
        $data['rows'] = $user->posts()
            ->whereActive(true)
            ->whereLangCode($langCode->name)
            ->orderByDesc('id')
            ->get();

        return view('index.index', $data);
    }

    public function sitemap()
    {
        $posts = Post::whereActive(true)->get();
        $content = View::make('index.sitemap')->with('posts', $posts);
        $response = Response::make($content);
        $response->header('content-Type', 'application/xml');

        return $response;
    }
}
