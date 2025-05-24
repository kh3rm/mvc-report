<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Book;
use App\Repository\BookRepository;


final class BookController extends AbstractController
{
    #[Route('/book', name: 'app_book')]
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }

    #[Route('/book/create', name: 'book_create')]
    public function createBook(
        ManagerRegistry $doctrine
    ): Response {
        $entityManager = $doctrine->getManager();

        $book = new Book();
        $book->setName('Keyboard_num_' . rand(1, 9));
        $book->setAuthor(rand(100, 999));

        $entityManager->persist($book);

        $entityManager->flush();

        return new Response('Saved new book with id '.$book->getId());
    }


    #[Route('/book/show', name: 'book_show_all')]
    public function showAllProduct(
        BookRepository $bookRepository
    ): Response {
        $books = $bookRepository
            ->findAll();

        $response = $this->json($books);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }


    #[Route('/book/show/{id}', name: 'book_by_id')]
    public function showProductById(
        BookRepository $bookRepository,
        int $id
    ): Response {
        $book = $bookRepository
            ->find($id);

        return $this->json($book);
    }


    #[Route('/book/delete/{id}', name: 'book_delete_by_id')]
    public function deletebookById(
        ManagerRegistry $doctrine,
        int $id
    ): Response {
        $entityManager = $doctrine->getManager();
        $book = $entityManager->getRepository(Book::class)->find($id);

        if (!$book) {
            throw $this->createNotFoundException(
                'No book found for id '.$id
            );
        }

        $entityManager->remove($book);
        $entityManager->flush();

        return $this->redirectToRoute('book_show_all');
    }


    #[Route('/book/update/{id}/{value}', name: 'book_update')]
    public function updatebook(
        ManagerRegistry $doctrine,
        int $id,
        int $value
    ): Response {
        $entityManager = $doctrine->getManager();
        $book = $entityManager->getRepository(Book::class)->find($id);

        if (!$book) {
            throw $this->createNotFoundException(
                'No book found for id '.$id
            );
        }

        $book->setAuthor($value);
        $entityManager->flush();

        return $this->redirectToRoute('book_show_all');
    }

    #[Route('/library/view', name: 'book_view_all')]
    public function viewAllProduct(
        BookRepository $bookRepository
    ): Response {
        $books = $bookRepository->findAll();

        $data = [
            'books' => $books
        ];

        return $this->render('book/view.html.twig', $data);
    }

    #[Route('/book/view/{value}', name: 'book_view_minimum_value')]
    public function viewbookWithMinimumValue(
        BookRepository $bookRepository,
        int $value
    ): Response {
        $books = $bookRepository->findByMinimumValue($value);

        $data = [
            'books' => $books
        ];

        return $this->render('book/view.html.twig', $data);
    }




    #[Route('/book/show/min/{author}', name: 'book_by_min_author')]
    public function showbookByMinimumAuthor(
        BookRepository $bookRepository,
        int $author
    ): Response {
        $books = $bookRepository->findByMinimumAuthor2($author);

        return $this->json($books);
    }

}
