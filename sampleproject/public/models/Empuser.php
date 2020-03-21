<?php
namespace App\Models;
class Empuser extends \Phalcon\Mvc\Model
{
    public function validation()
    {
        $validator = new Phalcon\Validation();
        
        $validator->add(
            "firstname",
            new Phalcon\Validation\Validator\InclusionIn(
                [
                    'message' => 'takahashi ka yamada no dochi ka daro!',
                    'domain' => [
                        'takahashi',
                        'yamada'
                    ]
                ]
            )
        );

        $validator->add(
            'firstname',
            new Phalcon\Validation\Validator\Uniqueness(
                [
                    'field'   => 'firstname',
                    'message' => 'The robot name must be unique',
                ]
            )
        );

        if ($this->year < 0) {
            $this->appendMessage(
                new Phalcon\Messages\Message('The year cannot be less than zero')
            );
        }

        if ($this->validationHasFailed() === true) {
            return false;
        }
    }
}
