<?php

declare(strict_types=1);

namespace App\Infrastructure\Serializer\Proxy;

use App\Domain\Model;

class Event
{
    public $id;
    public $name;
    public $type;
    public $position;
    public $period;
    public $posts;

    public function __construct(Model\Event $event)
    {
        $data = $event->getData();

        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->type = $data['type'];
        $this->position = $data['position'];
        $this->period = $data['period'];
        $this->posts = $data['posts'];
    }
}
