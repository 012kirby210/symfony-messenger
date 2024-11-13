<?php

namespace App\Message;

class DeletePhotoFile
{
    /**
     * @var string
     */
    private string $filename;

    public function __construct(string $filename)
    {

        $this->filename = $filename;
    }

    public function getFilename(): string
    {
        return $this->filename;
    }

}