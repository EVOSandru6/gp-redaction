<?php

namespace App\Model\Redaction\UseCase\Book\Create;

use App\Model\Flusher;
use App\Model\Redaction\Entity\Book\Book;
use App\Model\Redaction\Entity\Book\BookRepository;

class Handler
{
    public function __construct(
        private Flusher $flusher,
        private BookRepository $repository,
    )
    {
    }

    public function handle(Command $command)
    {
        $book = new Book(
            name: $command->name
        );

        $this->repository->add($book);

        $this->flusher->flush();
    }
}