<?php

namespace App\Forms\Admin\Users;

use Kris\LaravelFormBuilder\Form;

class EditForm extends Form
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
            ->add('active', 'select', [
                'label' => __('Active'),
                'choices' => [
                    1 => __('Yes'),
                    0 => __('No'),
                ],
            ])
            ->add('submit', 'submit', [
                'label' => __('Save'),
            ]);
    }
}
