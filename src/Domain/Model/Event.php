<?php

declare(strict_types=1);

namespace App\Domain\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use App\Domain\Model\Time\Period;
use App\Domain\Exception\Event\InvalidTypeException;

/**
 * @ORM\Entity
 */
class Event
{
    const TYPE_CONCERT = 'concert';
    const TYPE_ART_EXHIBITION = 'art exhibition';
    const TYPE_SPORT_EVENT = 'sport event';

    const VALID_TYPES = [
        self::TYPE_CONCERT,
        self::TYPE_ART_EXHIBITION,
        self::TYPE_SPORT_EVENT,
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

    public function __construct(
        Place $place,
        Period $period,
        string $name,
        string $type
    ) {
        if (!$this->isTypeValid($type)) {
            throw InvalidTypeException::triedWith($type);
        }
        $this->id = Uuid::uuid4();
        $this->start = $period->getStart();
        $this->end = $period->getEnd();
        $this->place = $place;
        $this->place->addEvent($this);
        $this->name = $name;
        $this->type = $type;
        $this->posts = new ArrayCollection();
    }

    public static function isTypeValid(string $type): bool
    {
        return in_array($type, self::VALID_TYPES);
    }

    public function addPost(Post $post)
    {
        $this->posts->add($post);
    }

    public function getPeriod(): Period
    {
        return new Period($this->start, $this->end);
    }

    public function getData(): array
    {
        return [
            'id' => $this->id,
            'period' => $this->getPeriod(),
            'place' => $this->place,
            'name' => $this->name,
            'type' => $this->type,
            'posts' => $this->posts,
            'position' => $this->place->getPosition(),
        ];
    }
}
