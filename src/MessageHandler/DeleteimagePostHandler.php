<?php

namespace App\MessageHandler;

use App\Message\AddPonkaToImage;
use App\Message\DeleteImagePost;
use App\Photo\PhotoFileManager;
use App\Photo\PhotoPonkaficator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class DeleteimagePostHandler implements MessageHandlerInterface
{
    private $entityManager;
    /**
     * @var PhotoFileManager
     */
    private $photoFileManager;

    public function __construct(EntityManagerInterface $entityManager, PhotoFileManager $photoFileManager){
        $this->entityManager = $entityManager;
        $this->photoFileManager = $photoFileManager;
    }
    public function __invoke(DeleteImagePost $message)
    {
        $imagePost = $message->getImagePost();
        $this->photoFileManager->deleteImage($imagePost->getFilename());

        $this->entityManager->remove($imagePost);
        $this->entityManager->flush();
    }
}