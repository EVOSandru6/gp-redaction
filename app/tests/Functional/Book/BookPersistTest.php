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
            'name' => 'Война и мир',
            'author_name' => 'Лев Николаевич Толстой'
        ];

        $booksQtyBefore = $this->em->getRepository(Book::class)->findAll();
        $authorsQtyBefore = $this->em->getRepository(Author::class)->findAll();

        self::assertEquals(0, count($booksQtyBefore));
        self::assertEquals(0, count($authorsQtyBefore));

        $this->client->request(method: 'post', uri: self::API_PREFIX . '/books', content: json_encode([
            'name' => $data['name'],
            'author_name' => $data['author_name'],
        ]));

        $booksQtyAfter = $this->em->getRepository(Book::class)->findAll();
        $authorsQtyAfter = $this->em->getRepository(Author::class)->findAll();

        self::assertGreaterThan(0, count($booksQtyAfter));
        self::assertGreaterThan(0, count($authorsQtyAfter));
    }
}