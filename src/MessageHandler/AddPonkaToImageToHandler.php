<?php

namespace App\MessageHandler;

use App\Message\AddPonkaToImage;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class AddPonkaToImageToHandler implements MessageHandlerInterface
{
    public function __invoke(AddPonkaToImage $message)
    {
        dump($message);
    }
}