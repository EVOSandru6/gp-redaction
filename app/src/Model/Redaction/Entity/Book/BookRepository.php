<?php

namespace App\Model\Redaction\Entity\Book;

use App\Model\Redaction\Entity\Author\Author;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\EntityRepository;

class BookRepository
{
    private EntityRepository $repo;

    public function __construct(
        private EntityManagerInterface $em
    )
    {
        $this->repo = $em->getRepository(Book::class);
    }

    public function findAll(): array
    {
        return $this->repo->findAll();
    }

    public function get(int $id): Book
    {
        if (!$book = $this->repo->find($id)) {
            throw new EntityNotFoundException('Book is not found.');
        }
        return $book;
    }

    public function findByName(string $name): array
    {
        return $this->repo->createQueryBuilder('o')
            ->where('o.name LIKE :name')
            ->setParameter('name', "%$name%")
            ->getQuery()
            ->getResult();
    }

    public function add(Book $book): void
    {
        $this->em->persist($book);
    }

    public function remove(Book $book)
    {
        $this->em->remove($book);
    }

    public function hasById(int $id): bool
    {
        return $this->repo->createQueryBuilder('t')
                ->select('COUNT(t.id)')
                ->andWhere('t.id = :id')
                ->setParameter(':id', $id)
                ->getQuery()->getSingleScalarResult() > 0;
    }
}