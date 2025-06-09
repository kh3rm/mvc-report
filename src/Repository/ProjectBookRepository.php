<?php

namespace App\Repository;

use App\Entity\ProjectBook;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProjectBook>
 */
class ProjectBookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProjectBook::class);
    }

    //    /**
    //     * @return Books[] Returns an array of Books objects
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

    //    public function findOneBySomeField($value): ?Books
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }


    /**
     * Find book with specific ISBN-nummer.
     *
     * @return ProjectBook[] Returns an array of Book objects
     */
    public function findByISBN(string $isbn): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.isbn = :isbn')
            ->setParameter('isbn', $isbn)
            ->orderBy('p.isbn', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }


    /**
     * Find all books with a given author.
     *
     * @return ProjectBook[] Returns an array of Book objects
     */
    public function findByAuthor(string $authorName): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.author === :author')
            ->setParameter('author', $authorName)
            ->orderBy('p.author', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }


    /**
     * Find all books with words in title.
     *
     * @return ProjectBook[] Returns an array of Book objects
     */
    public function findByTitle(string $title): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.title LIKE :title')
            ->setParameter('title', '%' . $title . '%')
            ->orderBy('p.author', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }


    /**
     * Reset the table to contain only the original books.
     */
    public function resetToInitialBooks(): void
    {
        $entityManager = $this->getEntityManager();

        $entityManager->createQuery('DELETE FROM ' . ProjectBook::class)->execute();

        $books = [
            ['title' => 'Elements of Poker', 'author' => 'Tommy Angelo', 'isbn' => '9781419680892', 'imagesource' => 'https://images.isbndb.com/covers/12576453482693.jpg'],
            ['title' => 'The Theory of Poker', 'author' => 'David Sklansky', 'isbn' => '9781880685006', 'imagesource' => 'https://images.isbndb.com/covers/16548033482857.jpg'],
            ['title' => 'Modern Poker Theory', 'author' => 'Michael Acevedo', 'isbn' => '9781909457898', 'imagesource' => 'https://images.isbndb.com/covers/23419053482867.jpg'],
            ['title' => 'Essential Poker Math', 'author' => 'Alton Hardin', 'isbn' => '9780998294506', 'imagesource' => 'https://images.isbndb.com/covers/11581093482543.jpg'],
            ['title' => 'Blackbelt in Blackjack', 'author' => 'Arnold Snyder', 'isbn' => '9781580421430', 'imagesource' => 'https://images.isbndb.com/covers/19091803482750.jpg'],
            ['title' => 'Beat the Dealer', 'author' => 'Edward O. Thorp', 'isbn' => '9780394703107', 'imagesource' => 'https://images.isbndb.com/covers/14111953482328.jpg']
        ];

        foreach ($books as $bookData) {
            $book = new ProjectBook();
            $book->setTitle($bookData['title']);
            $book->setAuthor($bookData['author']);
            $book->setIsbn($bookData['isbn']);
            $book->setImgsource($bookData['imagesource']);
            $entityManager->persist($book);
        }
        $entityManager->flush();
    }
}
