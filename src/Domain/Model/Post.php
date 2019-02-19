<?php

declare(strict_types=1);

namespace App\Domain\Model;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity
 */
class Post
{
    /**
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\Id
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $authorName;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $creationDate;

    /**
     * @ORM\ManyToOne(targetEntity="Event", inversedBy="posts")
     */
    private $event;

    public function __construct(Event $event, string $authorName, string $content)
    {
        $this->id = Uuid::uuid4();
        $this->creationDate = new \DateTimeImmutable();
        $this->event = $event;
        $event->addPost($this);
        $this->authorName = $authorName;
        $this->content = $content;
    }
}
