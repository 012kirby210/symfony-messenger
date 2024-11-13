<?php

namespace App\MessageHandler;

use App\Message\DeletePhotoFile;
use App\Photo\PhotoFileManager;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class DeletePhotoFileHandler implements MessageHandlerInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    private PhotoFileManager $photoManager;

    public function __construct(PhotoFileManager $photoManager)
    {

        $this->photoManager = $photoManager;
    }

    public function __invoke(DeletePhotoFile $deletePhotoFile)
    {
        $filename = $deletePhotoFile->getFileName();
        $this->photoManager->deleteImage($filename);
    }
}