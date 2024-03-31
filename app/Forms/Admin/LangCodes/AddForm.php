<?php

namespace App\Forms\Admin\LangCodes;

use Kris\LaravelFormBuilder\Form;

class AddForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('name', 'text', [
                'label_show' => true,
                'label' => __('Name'),
                'attr' => [
                    'placeholder' => __('Lang code name'),
                ],
                'help_block' => [
                    'text' => __('E.g. en, de, es, fa, ...'),
                    'tag' => 'p',
                    'attr' => []
                ],
            ])
            ->add(__('Add'), 'submit', [
                'label' => __('Add'),
            ]);
    }
}
