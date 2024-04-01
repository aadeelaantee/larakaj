<?php

namespace App\Forms\Front\Index;

use Kris\LaravelFormBuilder\Form;

class ProfileForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('name', 'text', [
                'label' => __('Name'),
            ])
            ->add('email', 'text', [
                'label' => __('Email'),
            ])
            ->add('twitter', 'text', [
                'label' => __('Twitter'),
            ])
            ->add('facebook', 'text', [
                'label' => __('Facebook'),
            ])
            ->add('linkedin', 'text', [
                'label' => __('Linkedin'),
            ])
            ->add('instagram', 'text', [
                'label' => __('Instagram'),
            ])
            ->add('github', 'text', [
                'label' => __('Github'),
            ])
            ->add('youtube', 'text', [
                'label' => __('Youtube'),
            ])
            ->add('image', 'file', [
                'label' => __('Profile image'),
            ])
            ->add('about', 'textarea', [
                'label' => __('About me'),
            ])
            ->add('submit', 'submit', [
                'label' => __('Save'),
            ]);
    }
}
