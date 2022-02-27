<?php

namespace App\Model\Redaction\Entity\Author;

use App\Model\Redaction\Entity\Book\Book;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

#[ORM\Entity]
#[ORM\Table(name: "authors")]
class Author
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "id", type: "integer")]
    private int $id;

    /* @var Collection|Book[] $books */
    #[ORM\ManyToMany(targetEntity: Book::class, inversedBy: "authors")]
    #[ORM\JoinTable(name: "author_book")]
    private Collection|array $books;

    #[Pure] public function __construct(
        #[ORM\Column(name: "name", type: "string")]
        private string $name
    )
    {
        $this->books = new ArrayCollection();
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

    public function addBook(Book $book)
    {
        $this->books->add($book);
    }
}