<?php

declare(strict_types=1);

namespace App\Domain\Model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Ramsey\Uuid\Uuid;
use App\Domain\Model\Place\Position;

/**
 * @ORM\Entity
 */
final class Place
{
    const TYPE_CONCERT_HALL = 'concert hall';
    const TYPE_GALLERY = 'gallery';
    const TYPE_GYM = 'gym';

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

    private function __construct(string $name, Position $position, string $type)
    {
        $this->id = Uuid::uuid4();
        $this->position = $position;
        $this->name = $name;
        $this->type = $type;
        $this->events = new ArrayCollection();
    }

    public static function createConcertHall(string $name, Position $position): self
    {
        return new self($name, $position, self::TYPE_CONCERT_HALL);
    }

    public static function createGallery(string $name, Position $position): self
    {
        return new self($name, $position, self::TYPE_GALLERY);
    }

    public static function createGym(string $name, Position $position): self
    {
        return new self($name, $position, self::TYPE_GYM);
    }

    public function addEvent(Event $event)
    {
        $this->events->add($event);
    }
}
