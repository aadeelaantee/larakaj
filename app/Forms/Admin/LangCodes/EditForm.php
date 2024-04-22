<?php

namespace App\Forms\Admin\LangCodes;

use Kris\LaravelFormBuilder\Form;

class EditForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('name', 'text', [
                'label_show' => true,
                'label' => __('Lang code'),
                'attr' => [
                    'placeholder' => __('Lang code name'),
                ],
                'help_block' => [
                    'text' => __('E.g. en, de, es, fa, ...'),
                    'tag' => 'p',
                    'attr' => []
                ],
            ])
            ->add('default', 'select', [
                'choices' => [
                    1 => __('Yes'),
                    0 => __('No'),
                ],
            ])
            ->add('calendar_type', 'select', [
                'label' => __('Calendar type'),
                'choices' => [
                    'gregorian' => __('Gregorian'),
                    'jalali' => __('Jalali'),
                ],
            ])
            ->add('rtl', 'checkbox', [
                'label' => __('Right to left'),
            ])
            ->add(__('Edit'), 'submit');
    }
}
