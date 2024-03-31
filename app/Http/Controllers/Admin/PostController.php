<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Kris\LaravelFormBuilder\FormBuilder;
use App\Forms\Admin\Posts\PostForm;
use App\Models\Post;
use App\Models\LangCode;

class PostController extends Controller
{
    public function index(Request $request, LangCode $langCode)
    {
        $rows = Post::orderBy('id', 'desc')
            ->whereLangCode($langCode->name)
            ->get();

        return view('admin.post.index', ['rows' => $rows]);
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

        return view('admin.post.edit', $data);
    }

    public function update(Request $request, LangCode $langCode, Post $post)
    {
        $validated = $request->validate([
            'get_comment'       => 'sometimes|required|boolean',
            'active'            => 'sometimes|required|boolean',
            'show_in_list'      => 'sometimes|required|boolean',
            'title'             => 'required|min:2',
            'slug'              => [
                'required',
                'min:2',
                Rule::unique('posts')->where(function ($query) use ($langCode) {
                    $query->where('lang_code', $langCode->name);
                })->ignore($post->id),
            ],
            'resume'            => 'required|min:2',
            'body'              => 'required|min:2',
            'meta_keywords'     => 'nullable',
            'meta_description'  => 'nullable',
            'tags' => 'nullable',
            'story_id' => [
                'nullable',
                'numeric',
                'integer',
                Rule::exists('stories', 'id')->where(function ($query) use ($langCode) {
                    $query->where('lang_code', $langCode->name);
                }),
            ],
            'author_note'       => 'nullable',
        ]);

        $post->get_comment      = $request->boolean('get_comment');
        $post->active           = $request->boolean('active');
        $post->show_in_list     = $request->boolean('show_in_list');
        $post->title            = $validated['title'];
        $post->slug             = $validated['slug'];
        $post->resume           = $validated['resume'];
        $post->body             = $validated['body'];
        $post->meta_keywords    = $validated['meta_keywords'];
        $post->meta_description = $validated['meta_description'];
        $post->story_id         = $validated['story_id'];
        $post->author_note      = $validated['author_note'];
       
        $post->save();

        return back()->with('messages', [
            ['success',  __('Post editted successfully.')],
        ]);
    }
}
