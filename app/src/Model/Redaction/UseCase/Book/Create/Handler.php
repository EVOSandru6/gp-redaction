<?php

namespace App\Model\Redaction\UseCase\Book\Create;

use App\Model\Flusher;
use App\Model\Redaction\Entity\Author\Author;
use App\Model\Redaction\Entity\Author\AuthorRepository;
use App\Model\Redaction\Entity\Book\Book;
use App\Model\Redaction\Entity\Book\BookRepository;

class Handler
{
    public function __construct(
        private Flusher $flusher,
        private BookRepository $bookRepository,
        private AuthorRepository $authorRepository,
    )
    {
    }

    public function handle(Command $command)
    {
        $author = $this->authorRepository->findByName($command->authorName) ??
            new Author(name: $command->authorName);

        $book = Book::create(
            name: $command->name,
            author: $author
        );

        $this->bookRepository->add($book);

        $this->flusher->flush();
    }
}