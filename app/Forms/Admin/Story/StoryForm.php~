<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;
use \App\Models\LangCode;

class StoryForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('name', 'text', [
                'label' => __('Name'),
                'attr' => [
                    'placeholder'=>__('Enter story name'),
                ],
            ])
            ->add('submit', 'submit', [
                'label' => __('Save'),
            ]);
    }


}
