<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use Illuminate\Validation\Rule;
use Kris\LaravelFormBuilder\FormBuilder;
use App\Forms\Admin\Posts\PostForm;
use App\Models\Post;
use App\Models\Tag;
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

        $this->setTags($request->tags, $langCode, $post);

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
            [__('New post'), route('admin.posts.create')],
            [ $post->locked ? __('Unlock') : __('Lock'), route('admin.posts.change_lock', ['post' => $post])],
        ];

        return view('admin.post.edit', $data);
    }

    public function changeLock(Request $request, LangCode $langCode, Post $post)
    {
        if ($post->locked) {
            $msg = __('Post unlocked successfully');
        } else {
            $msg = __('Post locked successfully');
        }

        $post->locked = ! $post->locked;
        $post->save();

        return back()->with('messages', [
            ['success', $msg],
        ]);

    }

    public function update(PostRequest $request, LangCode $langCode, Post $post)
    {
        if ($post->locked)
            return back()->with('messages', [
                ['danger', __('Post is locked')],
            ]);

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
        
        $post->resume_html      = app('commonMark')->convert($post->resume);
        $post->body_html        = app('commonMark')->convert($post->body);

        $post->save();

        $this->setTags($request->tags, $langCode, $post);

        return back()->with('messages', [
            ['success',  __('Post editted successfully.')],
        ]);
    }

    private function setTags(?string $tags, LangCode $langCode, Post $post)
    {
        if (blank($tags)) {
            $post->tags()->detach();
            return;
        }

        $tags = explode('+',$tags);
       
        if (count($tags)) {
            $tags = array_unique(array_map('trim', $tags));
            $existedTags = Tag::whereLangCode($langCode->name)
                ->whereIn('name', $tags)
                ->pluck('name', 'id')
                ->toArray();

            $addedIds = [];
            foreach (array_diff($tags, $existedTags) as $tag) {
                $addedIds[] = Tag::create([
                    'name' => $tag,
                    'lang_code' => $langCode->name,
                ])->id;
            }
            
            $tagsIds = array_merge(array_keys($existedTags), $addedIds);
            $post->tags()->sync($tagsIds);
        }
    }
}
