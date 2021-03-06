<?php

declare(strict_types=1);

namespace App\Domain\Model;

use App\Domain\Exception\Place\InvalidTypeException;
use App\Domain\Model\Geolocation\Position;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity
 */
class Place
{
    const TYPE_CONCERT_HALL = 'concert hall';
    const TYPE_GALLERY = 'gallery';
    const TYPE_GYM = 'gym';

    const VALID_TYPES = [
        self::TYPE_CONCERT_HALL,
        self::TYPE_GALLERY,
        self::TYPE_GYM,
    ];

    /**
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\Id
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\Column(type="string")
     */
    private $type;

    /**
     * @ORM\Column(type="point")
     */
    private $position;

    /**
     * @ORM\OneToMany(targetEntity="Event", mappedBy="place")
     */
    private $events;

    public function __construct(string $name, Position $position, string $type)
    {
        $this->id = Uuid::uuid4();
        if (!$this->isTypeValid($type)) {
            throw InvalidTypeException::triedWith($type);
        }
        $this->position = $position;
        $this->name = $name;
        $this->type = $type;
        $this->events = new ArrayCollection();
    }

    public static function isTypeValid(string $type): bool
    {
        return in_array($type, self::VALID_TYPES);
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function addEvent(Event $event)
    {
        $this->events->add($event);
    }

    public function getPosition(): Position
    {
        return $this->position;
    }

    public function getData(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'position' => $this->position,
            'events' => $this->events,
        ];
    }
}
