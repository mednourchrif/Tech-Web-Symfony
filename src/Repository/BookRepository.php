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
    // Fonction bch nlawjou liste mte3 books b category spécifique
    public function findBooksByCategory($category): array
    {
        // ma3andi leha 7ata tafsir GHIR A7FEDH W SOB W BADEL L LEZMOU YETBADEL
        return $this->createQueryBuilder('b')
            ->where('b.Category = :category')
            ->setParameter('category', $category)
            ->getQuery()
            ->getResult();
    }

    // Fonction bch nlawjou nombre mte3 books b category Romance
    public function countBooksByRomanceCategory(): int
    {
        // declaration de variable entityManager
        $entityManager = $this->getEntityManager();
        // DQL: requete sql bch nlawjou nombre mte3 books b category Romance
        $dql = "SELECT COUNT(b.id) 
                FROM App\Entity\Book b 
                WHERE b.Category = :category";
        // creation de query
        $query = $entityManager->createQuery($dql);
        // parametre de query category 7atineha Romance
        $query->setParameter('category', 'Romance');
        // execution de query
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
