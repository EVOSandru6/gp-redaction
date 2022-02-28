<?php

namespace App\Tests\Functional\Api\Book;

use App\Model\Redaction\Entity\Author\Author;
use App\Model\Redaction\Entity\Book\Book;
use App\Tests\Functional\DbWebTestCase;

class BookPersistTest extends DbWebTestCase
{
    public function test_persist_success()
    {
        $data = [
            'name' => 'War and peace|Война и мир',
            'author_name' => 'Лев Толстой'
        ];
        $id = $this->persist($data);

        $this->fetchFirstById($id, function ($name) {
            self::assertNotNull($name);
            self::assertEquals('War and peace', $name);
        });

        $query = 'мир';
        $this->search($query, function($books) {
            self::assertGreaterThan(0, count($books));
        });
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
            dump('persist_book_warning: ' . $jsonContent);
        }

        self::assertEquals(200, $response->getStatusCode());
        self::assertJson($jsonContent);
        $objContent = json_decode($jsonContent);

        $booksQtyAfter = $this->em->getRepository(Book::class)->findAll();
        $authorsQtyAfter = $this->em->getRepository(Author::class)->findAll();

        self::assertGreaterThan(count($booksQtyBefore), count($booksQtyAfter));
        self::assertGreaterThan(count($authorsQtyBefore), count($authorsQtyAfter));

        return $objContent->data->book->id;
    }

    private function search(string $q, callable $cb)
    {
        $this->client->request(method: 'get', uri: self::API_PREFIX . "/books/search?q=$q");

        $response = $this->client->getResponse();
        $jsonContent = $response->getContent();

        if ($response->getStatusCode() !== 200) {
            dump('search_book_warning: ' . $jsonContent);
        }

        self::assertEquals(200, $response->getStatusCode());
        self::assertJson($jsonContent);

        $objContent = json_decode($jsonContent);

        $cb($objContent->data->books);
    }

    private function fetchFirstById(int $id, callable $cb)
    {
        $this->client->request(method: 'get', uri: self::API_PREFIX . "/en/books/$id");

        $response = $this->client->getResponse();
        $jsonContent = $response->getContent();

        if ($response->getStatusCode() !== 200) {
            dump('fetchFirstById_book_warning: ' . $jsonContent);
        }

        self::assertEquals(200, $response->getStatusCode());
        self::assertJson($jsonContent);

        $objContent = json_decode($jsonContent);

        $cb($objContent->data->book?->name);
    }
}