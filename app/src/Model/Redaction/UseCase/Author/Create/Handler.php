<?php

namespace App\Model\Redaction\UseCase\Author\Create;

use App\Model\Flusher;
use App\Model\Redaction\Entity\Author\Author;
use App\Model\Redaction\Entity\Author\AuthorRepository;

class Handler
{
    public function __construct(
        private Flusher          $flusher,
        private AuthorRepository $repository,
    )
    {
    }

    public function handle(Command $command)
    {
        $author = new Author(
            name: $command->name
        );

        $this->repository->add($author);

        $this->flusher->flush();
    }
}