<?php

namespace App\Model;

use Doctrine\ORM\EntityManagerInterface;

class Flusher
{
    public function __construct(
        private EntityManagerInterface $em
    )
    {
    }

    public function flush(): void
    {
        $this->em->flush();
    }
}
