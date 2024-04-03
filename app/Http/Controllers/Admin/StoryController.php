<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Story;
use App\Models\LangCode;
use Kris\LaravelFormBuilder\FormBuilder;
use App\Forms\Admin\Story\StoryForm;
use Illuminate\Validation\Rule;

class StoryController extends Controller
{
    public function index(Request $request, FormBuilder $formBuilder, LangCode $langCode, )
    {
        $data = [];
        $data['title'] = __('Stories');

        $data['form'] = $formBuilder->create(StoryForm::class, [
            'method' => 'POST',
            'url' => route('admin.stories.store'),
        ]);

        $data['rows'] = Story::whereLangCode($langCode->name)->orderBy('id', 'desc')->get();
        return view('admin.story.index', $data);
    }

    public function edit(Request $request, FormBuilder $formBuilder, LangCode $langCode, Story $story)
    {
        $data = [];
        $data['title'] = __('Edit story');
        $data['row'] = $story;

        $data['form'] = $formBuilder->create(StoryForm::class, [
            'method' => 'patch',
            'url' => route('admin.stories.update', ['story' => $story]),
            'model' => $story,
        ]);

        $data['navigation'] = [
            [__('Stories'), route('admin.stories.index')],
        ];

        return view('admin.story.edit', $data);
    }

    public function store(Request $request, LangCode $langCode)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'min:2',
                Rule::unique('stories')->where(
                    function ($query) use ($langCode) {
                        return $query->where('lang_code', $langCode);
                    }
                ),
            ],
        ]);

        $obj = new Story();
        $obj->name = $validated['name'];
        $obj->lang_code = $langCode->name;
        $obj->save();

        return back()->with('messages', [
            ['success', __('Story added successfully.')],
        ]);
    }

    public function update(Request $request, LangCode $langCode, Story $story)
    {
        $langCode = $langCode->name;

        $validated = $request->validate([
            'name' => [
                'required',
                'min:2',
                Rule::unique('stories')->where(
                    function ($query) use ($langCode) {
                        return $query->where('lang_code', $langCode);
                    }
                )->ignore($story->id),
            ],
        ]);

        $story->name = $validated['name'];
        $story->save();

        return back()->with('messages', [
            ['success', __('Story editted successfully.')],
        ]);
    }

    public function destroy(Request $request, LangCode $langCode, Story $story)
    {
        /**
         * This story has posts and we cannot delete it.
         */ 
        if ($story->posts()->count())
            abort(404);

        $story->delete();

        return redirect()->route('admin.stories.index')->with('messages', [
            ['success', __('Story deleted successfully.')],
        ]);
    }
}
