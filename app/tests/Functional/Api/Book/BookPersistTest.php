<?php

namespace App\Tests\Functional\Api\Book;

use App\Model\Redaction\Entity\Author\Author;
use App\Model\Redaction\Entity\Book\Book;
use App\Tests\Functional\DbWebTestCase;
use function dump;

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

        $this->persist($data);

        $query = 'мир';

        $this->fetch($query);
    }

    private function persist(array $data)
    {
        $booksQtyBefore = $this->em->getRepository(Book::class)->findAll();
        $authorsQtyBefore = $this->em->getRepository(Author::class)->findAll();

        $this->client->request(method: 'post', uri: self::API_PREFIX . '/books', content: json_encode([
            'name' => $data['name'],
            'author_name' => $data['author_name'],
        ]));

        $response = $this->client->getResponse();
        $jsonContent = $response->getContent();

        if ($response->getStatusCode() !== 200) {
            dump('book_warning: ' . $jsonContent);
        }

        self::assertEquals(200, $response->getStatusCode());
        self::assertJson($jsonContent);

        $booksQtyAfter = $this->em->getRepository(Book::class)->findAll();
        $authorsQtyAfter = $this->em->getRepository(Author::class)->findAll();

        self::assertGreaterThan(count($booksQtyBefore), count($booksQtyAfter));
        self::assertGreaterThan(count($authorsQtyBefore), count($authorsQtyAfter));
    }

    private function fetch(string $q)
    {
        $this->client->request(method: 'get', uri: self::API_PREFIX . "/books/search?q=$q");

        $response = $this->client->getResponse();
        $jsonContent = $response->getContent();

        if ($response->getStatusCode() !== 200) {
            dump('book_warning: ' . $jsonContent);
        }

        self::assertEquals(200, $response->getStatusCode());
        self::assertJson($jsonContent);

        $objContent = json_decode($jsonContent);

        self::assertGreaterThan(0, count($objContent->data->books));
    }
}