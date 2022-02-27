<?php

namespace App\Tests\Functional\Book;

use App\Model\Redaction\Entity\Author\Author;
use App\Model\Redaction\Entity\Book\Book;
use App\Tests\Functional\DbWebTestCase;

class BookPersistTest extends DbWebTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_persist_success()
    {
        $data = [
            'name' => 'War and peace|Война и мир',
            'author_name' => 'Лев Толстой'
        ];

        $booksQtyBefore = $this->em->getRepository(Book::class)->findAll();
        $authorsQtyBefore = $this->em->getRepository(Author::class)->findAll();

        $this->client->request(method: 'post', uri: self::API_PREFIX . '/books', content: json_encode([
            'name' => $data['name'],
            'author_name' => $data['author_name'],
        ]));

        $response = $this->client->getResponse();
        $content = $response->getContent();

        if ($response->getStatusCode() !== 200) {
            dump('book_warning: ' . $content);
        }

        self::assertEquals(200, $response->getStatusCode());
        self::assertJson($content);

        $booksQtyAfter = $this->em->getRepository(Book::class)->findAll();
        $authorsQtyAfter = $this->em->getRepository(Author::class)->findAll();

        self::assertGreaterThan(count($booksQtyBefore), count($booksQtyAfter));
        self::assertGreaterThan(count($authorsQtyBefore), count($authorsQtyAfter));
    }
}