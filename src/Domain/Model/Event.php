<?php

declare(strict_types=1);

namespace App\Domain\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity
 */
class Event
{
    const TYPE_CONCERT = 'concert';
    const TYPE_ART_EXHIBITION = 'art exhibition';
    const TYPE_SPORT_EVENT = 'sport event';

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
     * @ORM\ManyToOne(targetEntity="Place", inversedBy="events")
     */
    private $place;

    /**
     * @ORM\OneToMany(targetEntity="Post", mappedBy="event")
     */
    private $posts;

    private function __construct(Place $place, string $name, string $type)
    {
        $this->id = Uuid::uuid4();
        $this->place = $place;
        $this->name = $name;
        $this->type = $type;
        $this->posts = new ArrayCollection();
    }

    public static function createConcert(Place $place, string $name): self
    {
        return new self($place, $name, self::TYPE_CONCERT);
    }

    public static function createArtExhibition(Place $place, string $name): self
    {
        return new self($place, $name, self::TYPE_ART_EXHIBITION);
    }

    public static function createSportEvent(Place $place, string $name): self
    {
        return new self($place, $name, self::TYPE_SPORT_EVENT);
    }

    public function addPost(Post $post)
    {
        $this->posts->add($post);
    }
}
