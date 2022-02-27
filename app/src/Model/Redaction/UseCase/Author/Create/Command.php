<?php

namespace App\Model\Redaction\UseCase\Author\Create;

class Command
{
    public function __construct(
        public string $name
    )
    {
    }
}