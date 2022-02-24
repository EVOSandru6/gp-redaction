<?php

namespace Model\Redaction\Entity\Author;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Model\Redaction\Entity\Book\Book;

#[ORM\Entity]
#[ORM\Table(name: "authors")]
class Author
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "id", type: "integer")]
    private int $id;

    /* @var Collection|Author[] $books */
    #[ORM\ManyToMany(targetEntity: Book::class, inversedBy: "books")]
    private Collection|array $books;

    public function __construct(
        #[ORM\Column(name: "name", type: "string")]
        private string $name
    )
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getBooks(): Collection|array
    {
        return $this->books;
    }
}