<?php

namespace App\Controller\ProjectController\ProjectLibraryController;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ProjectBookRepository;

/**
 * Class LibraryControllerView
 * @package App\Controller
 *
 * This controller handles the library-view-routes.
 */
final class ProjLibraryControllerView extends AbstractController
{
    /**
     * View all books route
     * @Route("/library/view", name="book_view_all", methods={"GET"})
     * @param ProjectBookRepository $bookRepository The book repository to find books.
     * @return Response Renders the view for all books in the library.
     */
    #[Route('proj/library/view', name: 'book_view_all_proj', methods: ['GET'])]
    public function viewAllBooksProj(
        ProjectBookRepository $bookRepository
    ): Response {
        $books = $bookRepository->findAll();

        $data = [
            'books' => $books
        ];

        return $this->render('project/library/view.html.twig', $data);
    }

    /**
     * View book by ISBN route
     * @Route("/library/view/{isbn}", name="book_view_isbn", methods={"GET"})
     * @param ProjectBookRepository $bookRepository The book repository to find books.
     * @param string $isbn The ISBN of the book to view.
     * @return Response Renders the view for the specified book.
     */
    #[Route('proj/library/view/{isbn}', name: 'book_view_isbn_proj', methods: ['GET'])]
    public function viewbookWithISBN(
        ProjectBookRepository $bookRepository,
        string $isbn
    ): Response {
        $books = $bookRepository->findByISBN($isbn);

        $data = [
            'books' => $books
        ];

        return $this->render('project/library/view_book.html.twig', $data);
    }
}
