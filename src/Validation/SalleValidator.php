<?php

namespace App\Validation;

use Respect\Validation\Validator;
use Respect\Validation\Exceptions\NestedValidationException;

class SalleValidator implements SalleValidatorInterface
{
    private const TYPES_AUTORISES = ['cours', 'informatique', 'laboratoire', 'amphitheatre', 'reunion'];

    public function validate(array $data): ValidationResult
    {
        $errors = [];
        $accepted = [];

        $rules = [
            'nom' => Validator::stringType()->length(2, 100),
            'batiment' => Validator::stringType()->length(2, 100),
            'capacite' => Validator::intVal()->between(1, 1000),
            'type' => Validator::in(self::TYPES_AUTORISES),
            'active' => Validator::in(['0', '1']),
        ];

        foreach ($rules as $field => $rule) {
            try {
                $rule->assert($data[$field] ?? null);
                $accepted[$field] = $data[$field];
            } catch (NestedValidationException $e) {
                $errors[$field] = $e->getMessages();
            }
        }

        if (isset($accepted['active'])) $accepted['active'] = $accepted['active'] === '1';

        return new ValidationResult(empty($errors), $errors, $accepted);
    }
}