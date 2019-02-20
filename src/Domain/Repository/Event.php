<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model;

interface Event
{
    public function add(Model\Event $event): void;
}
