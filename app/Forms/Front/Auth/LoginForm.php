<?php

namespace App\Forms\Front\Auth;

use Kris\LaravelFormBuilder\Form;

class LoginForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('email', 'text', [
                'label_show' => false,
                'attr' => [
                    'placeholder' => __('Email'),
                ],
            ])
            ->add('password', 'password', [
                'label_show' => false,
                'attr' => [
                    'placeholder' => __('Password'),
                ],
            ])
            ->add('submit', 'submit', [
                'label' => __('Login'),
            ]);
    }
}
