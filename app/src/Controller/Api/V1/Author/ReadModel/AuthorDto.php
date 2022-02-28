<?php

namespace App\Controller\Api\V1\Author\ReadModel;

class AuthorDto
{
    public function __construct(
        public int $id,
        public string $name,
    )
    {
    }
}