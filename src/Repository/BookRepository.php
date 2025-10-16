<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Book>
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    public function findBooksByCategory($category): array
    {
        return $this->createQueryBuilder('b')
            ->where('b.Category = :category') // 'category' en minuscule
            ->setParameter('category', $category)
            ->getQuery()
            ->getResult();
    }

    public function countBooksByRomanceCategory(): int
    {
        $entityManager = $this->getEntityManager();
        
        $dql = "SELECT COUNT(b.id) 
                FROM App\Entity\Book b 
                WHERE b.Category = :category";
        
        $query = $entityManager->createQuery($dql);
        $query->setParameter('category', 'Romance');
        
        return $query->getSingleScalarResult();
    }

    //    /**
    //     * @return Book[] Returns an array of Book objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('b.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Book
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
