<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use Illuminate\Validation\Rule;
use Kris\LaravelFormBuilder\FormBuilder;
use App\Forms\Admin\Posts\PostForm;
use App\Models\Post;
use App\Models\LangCode;

class PostController extends Controller
{
    public function index(Request $request, LangCode $langCode)
    {
        $data = [];
        $data['title'] = __('Posts');

        $data['rows'] = Post::orderBy('id', 'desc')
            ->whereLangCode($langCode->name)
            ->get();

        $data['navigation'] = [
            [__('New post'), route('admin.posts.create')],
        ];

        return view('admin.post.index', $data);
    }

    public function create(Request $request, FormBuilder $formBuilder, LangCode $langCode)
    {
        $data = [];

        $data['title'] = __('New post');
        $data['form'] = $formBuilder->create(PostForm::class, [
            'method' => 'post',
            'url' => route('admin.posts.store'),
            'data' => [
                'langCode' => $langCode,
            ]
        ]);

        $data['navigation'] = [
            [__('Posts'), route('admin.posts.index')],
        ];

        return view('admin.post.create', $data);
    }

    public function store(PostRequest $request, FormBuilder $formBuilder, LangCode $langCode)
    {
        $post = new Post();

        $post->lang_code        = $langCode->name;
        $post->user_id          = $request->user()->id;

        $post->get_comment      = $request->boolean('get_comment');
        $post->active           = $request->boolean('active');
        $post->show_in_list     = $request->boolean('show_in_list');

        $post->title            = $request->title;
        $post->slug             = $request->slug;
        $post->resume           = $request->resume;
        $post->body             = $request->body;
        $post->meta_keywords    = $request->meta_keywords;
        $post->meta_description = $request->meta_description;
        $post->story_id         = $request->story_id;
        $post->author_note      = $request->author_note;
       
        $post->save();

        return back()->with('messages', [
            ['success',  __('Post added successfully.')],
        ]);
    }


    public function edit(Request $request, FormBuilder $formBuilder, LangCode $langCode, Post $post) {
        $data = [];

        $data['title'] = __('Edit post');
        $data['row'] = $post;
        
        $data['form'] = $formBuilder->create(PostForm::class, [
            'method' => 'patch',
            'url' => route('admin.posts.update', ['post' => $post]),
            'model' => $post,
            'data' => [
                'langCode' => $langCode,
            ]
        ]);

        $data['navigation'] = [
            [__('Posts'), route('admin.posts.index')],
        ];

        return view('admin.post.edit', $data);
    }

    public function update(PostRequest $request, LangCode $langCode, Post $post)
    {
        $post->get_comment      = $request->boolean('get_comment');
        $post->active           = $request->boolean('active');
        $post->show_in_list     = $request->boolean('show_in_list');

        $post->title            = $request->title;
        $post->slug             = $request->slug;
        $post->resume           = $request->resume;
        $post->body             = $request->body;
        $post->meta_keywords    = $request->meta_keywords;
        $post->meta_description = $request->meta_description;
        $post->story_id         = $request->story_id;
        $post->author_note      = $request->author_note;
       
        $post->save();

        return back()->with('messages', [
            ['success',  __('Post editted successfully.')],
        ]);
    }
}
