<?php

declare(strict_types=1);

namespace App\Infrastructure\Serializer\Proxy;

use App\Domain\Model;

final class Post
{
    public $id;
    public $authorName;
    public $content;
    public $creationDate;

    public function __construct(Model\Post $post)
    {
        $data = $post->getData();

        $this->id = $data['id'];
        $this->authorName = $data['authorName'];
        $this->content = $data['content'];
        $this->creationDate = $data['creationDate'];
    }
}
