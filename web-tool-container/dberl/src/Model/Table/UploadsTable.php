<?php
// src/Model/Table/UploadsTable.php

namespace App\Model\Table;

use Cake\ORM\Table;

class UploadsTable extends Table {

    public function initialize(array $config) {
        $this->addBehavior('Josegonzalez/Upload.Upload', [
                // You can configure as many upload fields as possible,
                // where the pattern is `field` => `config`
                //
                // Keep in mind that while this plugin does not have any limits in terms of
                // number of files uploaded per request, you should keep this down in order
                // to decrease the ability of your users to block other requests.
                'file1' => []
        ]);
    }

    public function validationDefault(Validator $validator) {
        $validator
            ->add('file1', 'file', [
                    'rule' => ['uploadedFile', ['types' => ['image/png', 'image/jpeg', 'application/pdf']]], // It's what I expect to check
                    'message' => __("authorized extensions: jpg, png, pdf")
            ]);

        return $validator;
    }

}
?>
