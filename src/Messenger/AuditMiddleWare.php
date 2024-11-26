<?php

namespace App\Messenger;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;

class AuditMiddleWare implements MiddleWareInterface
{

    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {

        return $stack->next()->handle($envelope, $stack);
    }
}