<?php

namespace App\Controller\Api\V1\Book;

use App\Controller\Api\V1\Book\ReadModel\BookDto;
use App\Controller\Api\V1\Controller;
use App\Model\Redaction\Entity\Book\Book;
use App\Model\Redaction\Entity\Book\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v1/books')]
class BookSearchController extends Controller
{
    public function __construct(
        private BookRepository $bookRepository
    )
    {
    }

    #[Route('/search', methods: ['get'])]
    public function execute(Request $request): JsonResponse
    {
        $cb = function () use ($request) {
            $books = $this->bookRepository->findByName($request->query->get('q'));

            return [
                'books' => (new ArrayCollection($books))->map(fn(Book $book) => new BookDto(
                    id: $book->getId(),
                    name: $book->getName(),
                    authors: $book->getAuthors()->toArray()
                ))
            ];
        };

        return $this->commonHandler($request, [], $cb);
    }
}