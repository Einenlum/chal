<?php

declare(strict_types=1);

namespace App\Domain\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use App\Domain\Model\Time\Period;

/**
 * @ORM\Entity
 */
final class Event
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
     * @ORM\Column(type="datetime_immutable")
     */
    private $start;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $end;

    /**
     * @ORM\OneToMany(targetEntity="Post", mappedBy="event")
     */
    private $posts;

    private function __construct(
        Place $place,
        Period $period,
        string $name,
        string $type
    ) {
        $this->id = Uuid::uuid4();
        $this->start = $period->getStart();
        $this->end = $period->getEnd();
        $this->place = $place;
        $this->place->addEvent($this);
        $this->name = $name;
        $this->type = $type;
        $this->posts = new ArrayCollection();
    }

    public static function createConcert(Place $place, Period $period, string $name): self
    {
        return new self($place, $period, $name, self::TYPE_CONCERT);
    }

    public static function createArtExhibition(Place $place, Period $period, string $name): self
    {
        return new self($place, $period, $name, self::TYPE_ART_EXHIBITION);
    }

    public static function createSportEvent(Place $place, Period $period, string $name): self
    {
        return new self($place, $period, $name, self::TYPE_SPORT_EVENT);
    }

    public function addPost(Post $post)
    {
        $this->posts->add($post);
    }

    public function getPeriod(): Period
    {
        return new Period($this->start, $this->end);
    }
}
