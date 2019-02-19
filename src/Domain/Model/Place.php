<?php

declare(strict_types=1);

namespace App\Domain\Model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Ramsey\Uuid\Uuid;

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
     * @ORM\OneToMany(targetEntity="Event", mappedBy="place")
     */
    private $events;

    private function __construct(string $name, string $type)
    {
        $this->id = Uuid::uuid4();
        $this->name = $name;
        $this->type = $type;
        $this->events = new ArrayCollection();
    }

    public static function createConcertHall(string $name): self
    {
        return new self($name, self::TYPE_CONCERT_HALL);
    }

    public static function createGallery(string $name): self
    {
        return new self($name, self::TYPE_GALLERY);
    }

    public static function createGym(string $name): self
    {
        return new self($name, self::TYPE_GYM);
    }

    public function addEvent(Event $event)
    {
        $this->events->add($event);
    }
}
