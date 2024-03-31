<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Kris\LaravelFormBuilder\FormBuilder;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\LinkdumpCategory;
use App\Models\Linkdump;
use App\Models\LangCode;
use App\Forms\Admin\LdManager\CategoryForm;
use App\Forms\Admin\LdManager\LinkForm;

/**
 * 
 * Ld stands for Linkdump
 */
class LdManagerController extends Controller
{
    public function index(Request $request, FormBuilder $formBuilder, LangCode $langCode)
    {
        $data = [];
        $data['title'] = __('Linkdump manager');

        $data['rows'] = LinkdumpCategory::whereLangCode($langCode->name)
            ->orderBy('id', 'desc')
            ->get();

        $data['form'] = $formBuilder->create(CategoryForm::class, [
            'url' => route('admin.ldmanager.store_category'),
            'method' => 'post',
        ]);

        return view('admin.ldmanager.index', $data);
    }

    public function storeCategory(Request $request, LangCode $langCode)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'min:2', 
                Rule::unique('linkdump_categories')
                    ->where(function ($query) use ($langCode) {
                        $query->where('lang_code', $langCode->name);
                    }
                ),
            ],
            'integrated_with_template' => 'required|bool',
        ]);

        $obj = new LinkdumpCategory();
        $obj->name = $validated['name'];
        $obj->lang_code = $langCode->name;
        $obj->user_id = $request->user()->id;
        $obj->integrated_with_template = (bool) $validated['integrated_with_template'];

        $obj->save();

        return back()->with('messages', [
            ['success', __('Linkdump category added successfully')],
        ]);
    }

    public function category(Request $request, FormBuilder $formBuilder, LangCode $langCode, LinkdumpCategory $ldCategory)
    {
        $data = [];
        $data['title'] = __($ldCategory->name);
        $data['rows'] = $ldCategory->links()->orderByDesc('id')->get();
        $data['form'] = $formBuilder->create(LinkForm::class, [
            'method' => 'post',
            'url' => route('admin.ldmanager.store_link', ['ldCategory' => $ldCategory]),
        ]);

        return view('admin.ldmanager.category', $data);
    }


    public function storeLink(Request $request, LangCode $langCode, LinkdumpCategory $ldCategory)
    {
        $validated = $request->validate([
            'text' => 'required|min:2',
            'alt' => 'required|min:2',
            'link' => 'required|url',
        ]);

        $obj = new Linkdump();
        $obj->text = $validated['text'];
        $obj->alt = $validated['alt'];
        $obj->link = $validated['link'];
        $obj->linkdump_category_id = $ldCategory->id;
        $obj->user_id = $request->user()->id;

        $obj->save();

        return back()->with('messages', [
            ['success', __('Link added successfully')],
        ]);
    }

    public function destroyLink(Request $request, LangCode $langCode, Linkdump $ldLink)
    {
        $ldLink->delete();

        return back()->with('messages', [
            ['success', __('Link deleted successfully')],
        ]);
    }

    public function editLink(Request $request, FormBuilder $formBuilder, LangCode $langCode, Linkdump $ldLink)
    {
        $data = [];
        $data['title'] = __('Edit link');
        $data['row'] = $ldLink;
        $data['form'] = $formBuilder->create(LinkForm::class, [
            'method' => 'patch',
            'url' => route('admin.ldmanager.update_link', ['ldLink' => $ldLink]),
            'model' => $ldLink,
        ]);

        return view('admin.ldmanager.edit_link', $data);
    }


    public function updateLink(Request $request, LangCode $langCode, Linkdump $ldLink)
    {
        $validated = $request->validate([
            'text' => 'required|min:2',
            'alt' => 'required|min:2',
            'link' => 'required|url',
        ]);

        $ldLink->text = $validated['text'];
        $ldLink->alt = $validated['alt'];
        $ldLink->link = $validated['link'];


        $ldLink->save();

        return back()->with('messages', [
            ['success', __('Link editted successfully')],
        ]);
    }

    public function editCategory(Request $request, FormBuilder $formBuilder, LangCode $langCode, LinkdumpCategory $ldCategory)
    {
        $data = [];
        $data['title'] = __($ldCategory->name);
        $data['form'] = $formBuilder->create(CategoryForm::class, [
            'method' => 'patch',
            'url' => route('admin.ldmanager.update_category', ['ldCategory' => $ldCategory]),
            'model' => $ldCategory,
        ]);

        return view('admin.ldmanager.edit_category', $data);
    }

    public function updateCategory(Request $request, LangCode $langCode, LinkdumpCategory $ldCategory)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'min:2', 
                Rule::unique('linkdump_categories')
                    ->where(function ($query) use ($langCode) {
                        $query->where('lang_code', $langCode->name);
                    }
                )->ignore($ldCategory->id),
            ],
            'integrated_with_template' => 'required|bool',
        ]);

        $ldCategory->name = $validated['name'];
        $ldCategory->integrated_with_template = (bool) $validated['integrated_with_template'];

        $ldCategory->save();

        return back()->with('messages', [
            ['success', __('Linkdump category editted successfully')],
        ]);
    }
}
