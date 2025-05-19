<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImagePostControllerTest extends WebTestCase
{
    public function testCreate()
    {
        $client  = static::createClient();
        $uploadedFile = new UploadedFile(__DIR__ .
            DIRECTORY_SEPARATOR.'..'.
            DIRECTORY_SEPARATOR.'fixtures'.
            DIRECTORY_SEPARATOR.'test-image.jpeg',
        'test-image.jpeg');
        $client->request('POST', '/api/images',
            [],
            ['file' => $uploadedFile]
        );

        $this->assertResponseIsSuccessful();
    }
}