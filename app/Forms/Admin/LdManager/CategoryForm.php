<?php

namespace App\Forms\Admin\LdManager;

use Kris\LaravelFormBuilder\Form;

class CategoryForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('name', 'text', [
                'label' => __('Name'),
            ])
            ->add('integrated_with_template', 'select', [
                'label' => __('Integrated with template'),
                'choices' => [
                    0 => __('No'),
                    1 => __('Yes')
                ],
            ])
            ->add('submit', 'submit', [
                'label' => __('Save'),
            ]);
    }
}
