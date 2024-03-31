<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class CommentForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('parent_id', 'hidden', [
                'value' => '',
                'attr' => [
                    'id' => 'parent_id',
                ],
            ])
            ->add('name', 'text', [
                'label' => __('Name'),
            ])
            ->add('email', 'email', [
                'label' => __('Email'),
            ])
            ->add('comment', 'textarea', [
                'label' => __('Comment'),
            ])
            ->add('submit', 'submit', [
                'label' => __('Submit'),
                'attr' => [
                    'class' => 'btn btn-primary',
                ]
            ]);
    }
}
