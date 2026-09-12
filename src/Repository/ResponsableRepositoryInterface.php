<?php

namespace App\Repository;

use App\Model\Responsable;

interface ResponsableRepositoryInterface
{
    public function trouverParEmail(string $email): ?Responsable;
}
