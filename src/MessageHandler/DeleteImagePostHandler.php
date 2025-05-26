<?php

namespace App\MessageHandler;

use App\Message\DeleteImagePost;
use App\Message\Event\ImagePostDeletedEvent;
use App\MessageHandler\Event\RemoveFileWhenImagePostDeleted;
use App\Photo\PhotoFileManager;
use App\Repository\ImagePostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class DeleteImagePostHandler implements MessageHandlerInterface, LoggerAwareInterface
{

    use LoggerAwareTrait;
    private $entityManager;
    /**
     * @var PhotoFileManager
     */
    private $photoFileManager;
    /**
     * @var ImagePostRepository
     */
    private $imagePostRepository;
    private MessageBusInterface $eventBus;

    public function __construct(MessageBusInterface $eventBus,
                                EntityManagerInterface $entityManager,
                                PhotoFileManager $photoFileManager,
                                ImagePostRepository $imagePostRepository){
        $this->entityManager = $entityManager;
        $this->photoFileManager = $photoFileManager;
        $this->imagePostRepository = $imagePostRepository;
        $this->eventBus = $eventBus;
    }
    public function __invoke(DeleteImagePost $message)
    {
        $imagePostId = $message->getImagePostId();
        $imagePost = $this->imagePostRepository->find($imagePostId);
        if (!$imagePost) {
            if ($this->logger){
                $this->logger->alert(sprintf('Image post %d was missing', $imagePostId));
            }
        }

        $this->entityManager->remove($imagePost);
        $this->entityManager->flush();

        $imagePostDeletedEvent = new ImagePostDeletedEvent($imagePost->getFilename());
        $this->eventBus->dispatch($imagePostDeletedEvent);

    }
}
