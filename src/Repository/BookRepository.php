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


    /**
     * Find all producs having a value above the specified one.
     *
     * @return Product[] Returns an array of Product objects
     */
    public function findByMinimumValue($author): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.author >= :author')
            ->setParameter('author', $author)
            ->orderBy('p.author', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }


    /**
     * Find all books having a author above the specified one with SQL.
     *
     * @return [][] Returns an array of arrays (i.e. a raw data set)
     */
    public function findByMinimumauthor2($author): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT * FROM book AS p
            WHERE p.author >= :author
            ORDER BY p.author ASC
        ';

        $resultSet = $conn->executeQuery($sql, ['author' => $author]);

        return $resultSet->fetchAllAssociative();
    }
}
