<?php

namespace App\Forms\Admin\Posts;

use Kris\LaravelFormBuilder\Form;
use App\Models\Story;

class PostForm extends Form
{
    public function buildForm()
    {
        //dd($this->data['langCode']);
        //dd(get_object_vars($this));
        $tags = [];
        foreach ($this->model->tags as $tag)
            $tags[] = $tag->name;

        $this
            ->add('get_comment', 'checkbox', [
                'label' => __('Get comemnt'),
            ])

            ->add('active', 'checkbox', [
                'label' => __('Active'),
            ])

            ->add('show_in_list', 'checkbox', [
                'label' => __('Show in list'),
            ])

            ->add('title', 'text', [
                'label' => __('Title'),
            ])

            ->add('slug', 'text', [
                'label' => __('Slug'),
            ])

            ->add('resume', 'textarea', [
                'label' => __('Resume'),                
            ])

            ->add('body', 'textarea', [
                'label' => __('Body'),
            ])

            ->add('meta_keywords', 'textarea', [
                'label' => __('Meta keywords'),
            ])

            ->add('meta_description', 'textarea', [
                'label' => __('Meta description'),
            ])

            ->add('tags', 'text', [
                'label' => __('Tags'),
                'value' => implode('+', $tags),
            ])

            ->add('story_id', 'select', [
                'label' => __('Story'),
                'choices' => Story::whereLangCode($this->data['langCode']->name)->pluck('name', 'id')->toArray(),
                'empty_value' => __('You can select one story'),
            ])

            ->add('author_note', 'textarea', [
                'label' => __('Author note'),
            ])

            ->add('submit', 'submit', [
                'label' => __('Save'),
            ]);

    }
}
