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
    private $imagePost;

    public function __construct(ImagePost $imagePost)
    {
        $this->imagePost = $imagePost;
    }

    public function getImagePost(): ImagePost
    {
        return $this->imagePost;
    }


}