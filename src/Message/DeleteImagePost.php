<?php

namespace App\Message;

use App\Entity\ImagePost;
use Doctrine\ORM\EntityManagerInterface;

class DeleteImagePost
{
    /**
     * @var string
     */
    private $filename;
    /**
     * @var ImagePost
     */
    private $imagePostId;

    public function __construct(int $imagePostId)
    {
        $this->imagePostId = $imagePostId;
    }

    public function getImagePostId(): int
    {
        return $this->imagePostId;
    }


}