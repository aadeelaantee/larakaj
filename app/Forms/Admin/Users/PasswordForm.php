<?php

namespace App\Forms\Admin\Users;

use Kris\LaravelFormBuilder\Form;

class PasswordForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('password', 'password', [
                'label' => __('New password'),
            ])
            ->add('password_confirmation', 'password', [
                'label' => __('Confirm new password'),
            ])
            ->add('submit', 'submit', [
                'label' => __('Save'),
            ]);
    }
}
