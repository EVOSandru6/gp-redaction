<?php

namespace Model\Redaction\Entity\Author;

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
        if (!$recipient = $this->repo->find($id)) {
            throw new EntityNotFoundException('Author is not found.');
        }
        return $recipient;
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
}