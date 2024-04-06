<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tag;
use App\Models\LangCode;

class TagController extends Controller
{
    public function changeIwtStatus(Request $request, LangCode $langCode, Tag $tag)
    {
        $tag->integrated_with_template = ! $tag->integrated_with_template;
        $tag->save();

        return back()->with('messages', [
            ['success', __('Action done successfully.')],
        ]);
    }
}
