<?php

declare(strict_types=1);

namespace App\Domain\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Post
{
    /**
     * @ORM\Column(type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue
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
     * @ORM\ManyToOne(targetEntity="Event", inversedBy="posts")
     */
    private $event;

    public function __construct(Event $event, string $authorName, string $content)
    {
        $this->event = $event;
        $event->addPost($this);
        $this->authorName = $authorName;
        $this->content = $content;
    }
}
