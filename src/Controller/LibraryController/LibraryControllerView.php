<?php

namespace App\Controller\LibraryController;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\BookRepository;

/**
 * Class LibraryControllerView
 * @package App\Controller
 *
 * This controller handles the library-view-routes.
 */
final class LibraryControllerView extends AbstractController
{
    /**
     * View all books route
     * @Route("/library/view", name="book_view_all", methods={"GET"})
     * @param BookRepository $bookRepository The book repository to find books.
     * @return Response Renders the view for all books in the library.
     */
    #[Route('/library/view', name: 'book_view_all', methods: ['GET'])]
    public function viewAllBooks(
        BookRepository $bookRepository
    ): Response {
        $books = $bookRepository->findAll();

        $data = [
            'books' => $books
        ];

        return $this->render('book/view.html.twig', $data);
    }

    /**
     * View book by ISBN route
     * @Route("/library/view/{isbn}", name="book_view_isbn", methods={"GET"})
     * @param BookRepository $bookRepository The book repository to find books.
     * @param string $isbn The ISBN of the book to view.
     * @return Response Renders the view for the specified book.
     */
    #[Route('/library/view/{isbn}', name: 'book_view_isbn', methods: ['GET'])]
    public function viewbookWithISBN(
        BookRepository $bookRepository,
        string $isbn
    ): Response {
        $books = $bookRepository->findByISBN($isbn);

        $data = [
            'books' => $books
        ];

        return $this->render('book/view_book.html.twig', $data);
    }
}
