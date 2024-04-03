<?php

namespace App\Forms\Front\Auth;

use Kris\LaravelFormBuilder\Form;

class RegisterForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('name', 'text', [
                'label_show' => false,
                'attr' => [
                    'placeholder' => __('Name'),
                ],
            ])

            ->add('username', 'text', [
                'label_show' => false,
                'attr' => [
                    'placeholder' => __('Username'),
                ],
            ])

            ->add('email', 'text', [
                'label_show' => false,
                'attr' => [
                    'placeholder' => __('Email'),
                ],
            ])

            ->add('password', 'text', [
                'label_show' => false,
                'attr' => [
                    'placeholder' => __('Password'),
                ],
            ])

            ->add('password_confirmation', 'text', [
                'label_show' => false,
                'attr' => [
                    'placeholder' => __('Password confirmation'),
                ],
            ])

            ->add('submit', 'submit', [
                'label' => __('Register'),
            ]);


    }
}
