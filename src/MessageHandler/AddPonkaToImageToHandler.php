<?php

namespace App\MessageHandler;

use App\Message\AddPonkaToImage;
use App\Photo\PhotoFileManager;
use App\Photo\PhotoPonkaficator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class AddPonkaToImageToHandler implements MessageHandlerInterface
{

    private $ponkaficator;
    private $photoManager;
    private $entityManager;
    public function __construct(PhotoPonkaficator $ponkaficator,
                                PhotoFileManager $photoFileManager,
                                EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
        $this->photoManager = $photoFileManager;
        $this->ponkaficator = $ponkaficator;
    }
    public function __invoke(AddPonkaToImage $message)
    {
        $imagePost = $message->getImagePost();
        $updatedContents = $this->ponkaficator->ponkafy(
            $this->photoManager->read($imagePost->getFilename())
        );
        $this->photoManager->update($imagePost->getFilename(), $updatedContents);
        $imagePost->markAsPonkaAdded();
        $this->entityManager->flush();
    }
}