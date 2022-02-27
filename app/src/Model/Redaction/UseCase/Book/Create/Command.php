<?php

namespace App\Model\Redaction\UseCase\Book\Create;

class Command
{
    public function __construct(
        public string $name
    )
    {
    }
}