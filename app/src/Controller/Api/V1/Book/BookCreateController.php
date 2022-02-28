<?php

namespace App\Controller\Api\V1\Book;

use App\Controller\Api\V1\Author\ReadModel\AuthorDto;
use App\Controller\Api\V1\Book\ReadModel\BookDto;
use App\Controller\Api\V1\Controller;
use App\Model\Redaction\Entity\Author\Author;
use App\Model\Redaction\UseCase\Book\Create\Command;
use App\Model\Redaction\UseCase\Book\Create\Handler as BookCreateHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v1/books')]
class BookCreateController extends Controller
{
    public function __construct(
        private BookCreateHandler $bookCreateHandler
    )
    {
    }

    #[Route('' , methods: ['post'])]
    public function execute(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $cb = function () use ($data) {
            $command = new Command(
                name: $data['name'],
                authorName: $data['author_name'],
            );

            $book = $this->bookCreateHandler->handle($command);

            return [
                'book' => new BookDto(
                    id: $book->getId(),
                    name: $book->getName(),
                    authors: $book->getAuthors()->map(fn(Author $author) => new AuthorDto(id: $author->getId(), name: $author->getName()))->toArray()
                )
            ];
        };

        return $this->commonHandler($request, [], $cb);
    }
}