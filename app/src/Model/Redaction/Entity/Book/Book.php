<?php

namespace App\Model\Redaction\Entity\Book;

use App\Model\Redaction\Entity\Author\Author;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

#[ORM\Entity]
#[ORM\Table(name: "books")]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "id", type: "integer")]
    private int $id;

    /* @var Collection|Author[] $authors */
    #[ORM\ManyToMany(targetEntity: Author::class, inversedBy: "books", cascade: ["persist"])]
    private Collection|array $authors;

    #[Pure] private function __construct(
        #[ORM\Column(name: "name", type: "string")]
        private string $name
    )
    {
        $this->authors = new ArrayCollection();
    }

    public static function create(string $name, Author $author): static
    {
        $book = new static($name);
        $book->addAuthor($author);
        return $book;
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

    public function addAuthor(Author $author)
    {
        $this->authors->add($author);
    }
}
