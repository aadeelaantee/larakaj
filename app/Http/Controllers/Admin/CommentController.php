<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LangCode;
use App\Models\Comment;
use App\Models\Post;

class CommentController extends Controller
{
    public function index(Request $request, LangCode $langCode, Post $post = null)
    {
        $data = [];
        $data['title'] = __('Comments');
        $data['post'] = $post;

        if (! $post) {
            $data['comments'] = Comment::whereHas('post', function ($query) use ($langCode) {
                return $query->where('lang_code', $langCode->name);
            })->whereActive(false)->get();
        } else {
            $data['comments'] = $post->comments;
        }

        return view('admin.comment.index', $data);
    }

    public function activate(Request $request, LangCode $langCode, Comment $comment)
    {
        if ($comment->active)
            abort(404);

        $comment->active = true;
        $comment->save();

        return back()->with('messages', [
            ['success', __('Comment activated successfully')],
        ]);
    }

    public function deactivate(Request $request, LangCode $langCode, Comment $comment)
    {
        if (! $comment->active)
            abort(404);

        $comment->active = false;
        $comment->save();

        return back()->with('messages', [
            ['success', __('Comment deactivated successfully')],
        ]);
    }

    public function delete(Request $request, LangCode $langCode, Comment $comment)
    {
        if ($comment->children()->count())
            return back()->with('messages', [
            ['danger', __('There is another comment(s) for this comment')],
        ]);

        $comment->delete();

        return back()->with('messages', [
            ['success', __('Comment deleted successfully')],
        ]);
    }
}
