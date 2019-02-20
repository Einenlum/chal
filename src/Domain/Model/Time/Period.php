<?php

declare(strict_types=1);

namespace App\Domain\Model\Time;

use App\Domain\Exception\Time\InvalidPeriodException;

final class Period
{
    private $start;

    private $end;

    public function __construct(
        \DateTimeImmutable $start,
        \DateTimeImmutable $end
    ) {
        if ($end < $start) {
            throw InvalidPeriodException::create();
        }

        $this->start = $start;
        $this->end = $end;
    }

    public function getStart(): \DateTimeImmutable
    {
        return $this->start;
    }

    public function getEnd(): \DateTimeImmutable
    {
        return $this->end;
    }
}
