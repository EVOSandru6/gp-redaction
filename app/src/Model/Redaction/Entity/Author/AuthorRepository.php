<?php

namespace App\Model\Redaction\Entity\Author;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\EntityRepository;

class AuthorRepository
{
    private EntityRepository $repo;

    public function __construct(
        private EntityManagerInterface $em
    )
    {
        $this->repo = $em->getRepository(Author::class);
    }

    public function findAll(): array
    {
        return $this->repo->findAll();
    }

    public function get(int $id): Author
    {
        if (!$author = $this->repo->find($id)) {
            throw new EntityNotFoundException('Author is not found.');
        }
        return $author;
    }

    public function findByName(string $name): ?Author
    {
        return $this->repo->findOneBy(['name' => $name]);
    }

    public function add(Author $author): void
    {
        $this->em->persist($author);
    }

    public function remove(Author $author)
    {
        $this->em->remove($author);
    }

    public function hasById(int $id): bool
    {
        return $this->repo->createQueryBuilder('t')
                ->select('COUNT(t.id)')
                ->andWhere('t.id = :id')
                ->setParameter(':id', $id)
                ->getQuery()->getSingleScalarResult() > 0;
    }

    public function hasByName(string $name): bool
    {
        return $this->repo->createQueryBuilder('t')
                ->select('COUNT(t.id)')
                ->andWhere('t.name = :name')
                ->setParameter(':name', $name)
                ->getQuery()->getSingleScalarResult() > 0;
    }
}