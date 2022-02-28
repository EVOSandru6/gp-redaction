<?php

namespace App\Tests\Functional\Api\Author;

use App\Model\Redaction\Entity\Author\Author;
use App\Tests\Functional\DbWebTestCase;
use function dump;

class AuthorPersistTest extends DbWebTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_persist_success()
    {
        $authorsQtyBefore = $this->em->getRepository(Author::class)->findAll();

        $authorName = 'Михаил Юрьевич Лермонтов';

        $this->client->request(method: 'post', uri: self::API_PREFIX . '/authors', content: json_encode([
            'name' => $authorName,
        ]));

        $response = $this->client->getResponse();
        $jsonContent = $response->getContent();

        if ($response->getStatusCode() !== 200) {
            dump('author_warning: ' . $jsonContent);
        }

        self::assertEquals(200, $response->getStatusCode());
        self::assertJson($jsonContent);

        $authorsQtyAfter = $this->em->getRepository(Author::class)->findAll();

        self::assertGreaterThan(count($authorsQtyBefore), count($authorsQtyAfter));
    }
}