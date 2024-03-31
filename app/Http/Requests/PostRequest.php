<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $postId   = $this->route('post') ? $this->route('post')->id : -1;
        $langCode = $this->route('langCode');

        return [
            'get_comment'       => 'sometimes|required|boolean',
            'active'            => 'sometimes|required|boolean',
            'show_in_list'      => 'sometimes|required|boolean',
            'title'             => 'required|min:2',
            'slug'              => [
                'required',
                'min:2',
                Rule::unique('posts')->where(function ($query) use ($langCode) {
                    $query->where('lang_code', $langCode->name);
                })->ignore($postId),
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
        ];
    }
}
