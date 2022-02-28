<?php

namespace App\Controller\Api\V1\Book;

use App\Controller\Api\V1\Author\ReadModel\AuthorDto;
use App\Controller\Api\V1\Book\ReadModel\BookDto;
use App\Controller\Api\V1\Controller;
use App\Model\Redaction\Entity\Author\Author;
use App\Model\Redaction\Entity\Book\Book;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v1')]
class BookDetailController extends Controller
{
    #[Route('/{_locale}/books/{book}', requirements: ['_locale' => 'en|ru'], methods: ['get'])]
    public function execute(Request $request, Book $book): JsonResponse
    {
        $locale = $request->attributes->get('_locale');

        $cb = fn() => [
            'book' => new BookDto(
                id: $book->getId(),
                name: $book->getNameByLang($locale),
                authors: $book->getAuthors()->map(fn(Author $author) => new AuthorDto(id: $author->getId(), name: $author->getName()))->toArray()
            )
        ];

        return $this->commonHandler($request, [], $cb);
    }
}