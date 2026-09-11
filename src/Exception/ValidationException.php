<?php

namespace App\Exception;

class ValidationException extends \Exception
{
    private array $errors;

    public function __construct(array $errors)
    {
        parent::__construct('Les données fournies sont invalides.');
        $this->errors = $errors;
    }

    public function errors(): array
    {
        return $this->errors;
    }
}