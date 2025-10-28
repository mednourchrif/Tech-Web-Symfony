<?php
// src/Service/BookManagerService.php

namespace App\Service;

use App\Entity\Author;
use App\Entity\Book;
use Doctrine\ORM\EntityManagerInterface;

class BookManagerService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function countBooksByAuthor(Author $author): int
    {
        $bookRepository = $this->entityManager->getRepository(Book::class);
        
        return $bookRepository->createQueryBuilder('b')
            ->select('COUNT(b.id)')
            ->where('b.author = :author')
            ->setParameter('author', $author)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function bestAuthors(int $minBooks = 3): array
    {
        $authorRepository = $this->entityManager->getRepository(Author::class);
        
        return $authorRepository->createQueryBuilder('a')
            ->select('a', 'COUNT(b.id) as bookCount')
            ->leftJoin('a.books', 'b')
            ->groupBy('a.id')
            ->having('COUNT(b.id) > :minBooks')
            ->setParameter('minBooks', $minBooks)
            ->orderBy('bookCount', 'DESC')
            ->getQuery()
            ->getResult();
    }
}