<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\LangCode;
use Kris\LaravelFormBuilder\FormBuilder;
use App\Forms\Admin\LangCodes\AddForm;
use App\Forms\Admin\LangCodes\EditForm;

class LangCodeController extends Controller
{
    public function index(Request $request, FormBuilder $formBuilder, LangCode $langCode)
    {
        $data = [];
        $data['title'] = __('language codes list');
        $data['rows'] = LangCode::orderByDesc('id')->get();
        $data['form'] = $formBuilder->create(AddForm::class, [
            'method' => 'post',
            'url' => route('admin.lang_codes.store'),
        ]);

        return view('admin.lang_code.index', $data);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:lang_codes|regex:/^[a-z]{2}(?:_[A-Z]{2})?$/',
        ]);

        $obj = new LangCode();
        $obj->name = $validated['name'];
        $obj->default = ! LangCode::count() ? true : false;
        $obj->save();

        return back()->with('messages', [
            ['success', __('Lang code added successfully.')],
        ]);
    }

    public function edit(Request $request, FormBuilder $formBuilder, LangCode $langCode, LangCode $lc)
    {
        $data = [];
        $data['title'] = __('Edit language code');
        
        $data['navigation'] = [
            [__('Lang codes'), route('admin.lang_codes.index')],
        ];

        $data['form'] = $formBuilder->create(EditForm::class, [
            'method' => 'patch',
            'url' => route('admin.lang_codes.update', ['lc' => $lc]),
            'model' => $lc,
        ]);

        return view('admin.lang_code.edit', $data);
    }

    public function update(Request $request, LangCode $langCode, LangCode $lc)
    {
        $validated = $request->validate([
            'name'     => [
                'required',
                'regex:/^[a-z]{2}(?:_[A-Z]{2})?$/',
                Rule::unique('lang_codes')->ignore($lc->id),
            ],

            'default' => 'required|boolean',
            'rtl'     => 'sometimes|boolean',
        ]);

        $nowIsDefault = $lc->default;

        $lc->name = $validated['name'];
        $lc->default = (bool) $validated['default'];
        $lc->rtl = $request->boolean('rtl');

        /*
        |----------------------------------------------------------------------
        | Error
        |----------------------------------------------------------------------
        |
        | No default language code for application. Return with error.
        |
        */

        if ($nowIsDefault && ! $lc->default) {
            return back()->withErrors([
                'default' => __('Application without default language!'),
            ]);
        }

        if ($lc->default) {
            LangCode::whereDefault(true)->update(['default' => false]);
        }

        $lc->save();

        return back()->with('messages', [
            ['success', __('Lang code editted successfully.')],
        ]);
    }
}
