<?php

namespace Model\Redaction\Entity\Book;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Model\Redaction\Entity\Author\Author;

#[ORM\Entity]
#[ORM\Table(name: "books")]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "id", type: "integer")]
    private int $id;

    /* @var Collection|Author[] $authors */
    #[ORM\ManyToMany(targetEntity: Author::class, inversedBy: "authors")]
    #[ORM\JoinTable(name: "author_book")]
    private Collection|array $authors;

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

    public function getAuthors(): Collection|array
    {
        return $this->authors;
    }
}
