<?php

declare(strict_types=1);

namespace App\Infrastructure\Serializer\Proxy;

use App\Domain\Model;
use Ramsey\Uuid\Uuid;

class Place
{
    public $id;
    public $name;
    public $type;
    public $position;
    public $events;

    public function __construct(Model\Place $place)
    {
        $data = $place->getData();

        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->type = $data['type'];
        $this->position = $data['position'];
        $this->events = $data['events'];
    }
}
