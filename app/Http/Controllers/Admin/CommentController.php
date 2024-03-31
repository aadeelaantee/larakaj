<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LangCode;
use App\Models\Comment;

class CommentController extends Controller
{
    public function index(Request $request, LangCode $langCode)
    {
        $data = [];
        $data['title'] = __('Comments');
        $data['comments'] = Comment::whereHas('post', function ($query) use ($langCode) {
            return $query->where('lang_code', $langCode->name);
        })->whereActive(false)->get();

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
