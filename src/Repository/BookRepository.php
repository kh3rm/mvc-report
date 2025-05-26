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
     * @return Book[] Returns an array of Product objects
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
     * @return Book[] Returns an array of Book objects
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
     * @return Book[] Returns an array of Book objects
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

        $entityManager->createQuery('DELETE FROM ' . Book::class)->execute();

        $books = [
            ['title' => 'The Innocents Abroad', 'author' => 'Mark Twain', 'isbn' => '9798690953713', 'imagesource' => 'https://images.isbndb.com/covers/25781953488842.jpg'],
            ['title' => 'The Visit', 'author' => 'Friedrich Dürrenmatt', 'isbn' => '9780802144263', 'imagesource' => 'https://images.isbndb.com/covers/16083963482473.jpg'],
            ['title' => 'Lord Jim', 'author' => 'Joseph Conrad', 'isbn' => '9788513011713', 'imagesource' => 'https://images.isbndb.com/covers/1179123485219.jpg'],
            ['title' => 'The Library of Babel', 'author' => 'Jorge Luis Borges', 'isbn' => '9781567921236', 'imagesource' => 'https://images.isbndb.com/covers/6433023482746.jpg'],
            ['title' => 'Invisible Cities', 'author' => 'Italo Calvino', 'isbn' => '9780063417625', 'imagesource' => 'https://images.isbndb.com/covers/15380353482210.jpg'],
            ['title' => 'The Baron In The Trees', 'author' => 'Italo Calvino', 'isbn' => '9780544959118', 'imagesource' => 'https://images.isbndb.com/covers/39403482382.jpg']
        ];

        foreach ($books as $bookData) {
            $book = new Book();
            $book->setTitle($bookData['title']);
            $book->setAuthor($bookData['author']);
            $book->setIsbn($bookData['isbn']);
            $book->setImgsource($bookData['imagesource']);
            $entityManager->persist($book);
        }
        $entityManager->flush();
    }

}
