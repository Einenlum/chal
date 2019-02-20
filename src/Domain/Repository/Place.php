<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model;

interface Place
{
    public function add(Model\Place $place): void;
}
