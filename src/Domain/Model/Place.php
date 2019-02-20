<?php

declare(strict_types=1);

namespace App\Domain\Model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Ramsey\Uuid\Uuid;
use App\Domain\Model\Geolocation\Position;
use App\Domain\Exception\Place\InvalidTypeException;

/**
 * @ORM\Entity
 */
final class Place
{
    const TYPE_CONCERT_HALL = 'concert hall';
    const TYPE_GALLERY = 'gallery';
    const TYPE_GYM = 'gym';

    const VALID_TYPES = [
        self::TYPE_CONCERT_HALL,
        self::TYPE_GALLERY,
        self::TYPE_GYM
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
        return in_array($value, self::VALID_TYPES);
    }

    public function addEvent(Event $event)
    {
        $this->events->add($event);
    }
}
