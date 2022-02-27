<?php

namespace App\Controller\Api\V1\Book\ReadModel;

class BookDto
{
    public function __construct(
        public int $id,
        public string $name,
        public array $authors
    )
    {
    }
}