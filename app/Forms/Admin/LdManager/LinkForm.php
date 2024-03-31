<?php

namespace App\Forms\Admin\LdManager;

use Kris\LaravelFormBuilder\Form;

class LinkForm extends Form
{

    public function buildForm()
    {
        $this
            ->add('text', 'text', [
                'label' => __('Text'),
            ])
            ->add('alt', 'text', [
                'label' => __('Mouse text'),
            ])
            ->add('link', 'text', [
                'label' => __('Link'),
            ])
            ->add('submit', 'submit', [
                'label' => __('Save'),
            ]);
    }
}
