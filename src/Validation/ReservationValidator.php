<?php

namespace App\Validation;

use Respect\Validation\Validator;
use Respect\Validation\Exceptions\NestedValidationException;

class ReservationValidator implements ReservationValidatorInterface
{
    public function validate(array $data): ValidationResult
    {
        $errors = [];
        $accepted = [];

        $rules = [
            'salle_id' => Validator::intVal()->positive(),
            'responsable' => Validator::stringType()->length(2, 120),
            'email' => Validator::email(),
            'motif'  => Validator::stringType()->length(5, 255),
            'date_debut' => Validator::dateTime('Y-m-d\TH:i'),
            'date_fin' => Validator::dateTime('Y-m-d\TH:i'),
        ];

        foreach ($rules as $field => $rule) {
            try {
                $rule->assert($data[$field] ?? null);
                $accepted[$field] = $data[$field];
            } catch (NestedValidationException $e) {
                $errors[$field] = $e->getMessages();
            }
        }

        return new ValidationResult(empty($errors), $errors, $accepted);
    }
}