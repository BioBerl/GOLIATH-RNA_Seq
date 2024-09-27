<?php
// in src/Form/ContactForm.php
namespace App\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;

class SubmitForm extends Form
{

    protected function _buildSchema(Schema $schema)
    {
        return $schema->addField('tipo', ['type' => 'radio'])
            ->addField('email', ['type' => 'string'])
            ->addField('body', ['type' => 'text']);
    }

    protected function _buildValidator(Validator $validator)
    {
        /*
        $validator->add('name', 'length', [
                'rule' => ['minLength', 10],
                'message' => 'A name is required'
        ])->add('email', 'format', [
            'rule' => 'email',
            'message' => 'A valid email address is required',
        ]);

        return $validator;
        */

        $validator
            ->add('file1', [
                    'validExtension' => [
                    'rule' => ['extension',['gz']], // default  ['gif', 'jpeg', 'png', 'jpg']
                    'message' => __('These files extension are allowed: .fastq.gz')
                    ]
            ])
            ->allowEmpty('file2')
            ->add('file2', [
                    'validExtension' => [
                    'rule' => ['extension',['gz']], // default  ['gif', 'jpeg', 'png', 'jpg']
                    'message' => __('These files extension are allowed: .fastq.gz')
                    ],
            ]);

        return $validator;

    }

    protected function _execute(array $data)
    {
        // Send an email.
        return true;
    }
}
