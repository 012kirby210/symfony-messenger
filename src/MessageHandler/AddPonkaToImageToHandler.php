<?php

namespace App\MessageHandler;

use App\Entity\ImagePost;
use App\Message\AddPonkaToImage;
use App\Photo\PhotoFileManager;
use App\Photo\PhotoPonkaficator;
use App\Repository\ImagePostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class AddPonkaToImageToHandler implements MessageHandlerInterface, LoggerAwareInterface
{

    use LoggerAwareTrait;
    private $ponkaficator;
    private $photoManager;
    private $entityManager;
    /**
     * @var ImagePostRepository
     */
    private $imagePostRepository;
    /**
     * @var ImagePost
     */
    private $imagePost;

    public function __construct(PhotoPonkaficator      $ponkaficator,
                                PhotoFileManager       $photoFileManager,
                                EntityManagerInterface $entityManager,
                                ImagePostRepository    $imagePostRepository){
        $this->entityManager = $entityManager;
        $this->photoManager = $photoFileManager;
        $this->ponkaficator = $ponkaficator;
        $this->imagePostRepository = $imagePostRepository;
    }
    public function __invoke(AddPonkaToImage $message)
    {
        $imagePostId = $message->getImagePostId();
        $imagePost = $this->imagePostRepository->find($imagePostId);

        if (!$imagePost) {
            // for testing purpose, the container could be unavailable
            if ($this->logger){
                $this->logger->alert(sprintf('Image post %d was missing', $imagePostId));
            }
            return;
        }

        if (rand(0, 10) < 7) {
            throw new \Exception(('Some random failure'));
        }
        $updatedContents = $this->ponkaficator->ponkafy(
            $this->photoManager->read($imagePost->getFilename())
        );
        $this->photoManager->update($imagePost->getFilename(), $updatedContents);
        $imagePost->markAsPonkaAdded();
        $this->entityManager->flush();
    }
}