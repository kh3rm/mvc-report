<?php

namespace App\Controller\ProjectController\ProjectLibraryController;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ProjectBookRepository;

/**
 * Class LibraryControllerJson
 * @package App\Controller
 *
 * This controller handles the library-json-routes.
 */
final class ProjLibraryControllerJson extends AbstractController
{
    /**
     * Retrieve all books in JSON format
     * @Route("/api/library/books", name="book_json_show_all")
     * @param ProjectBookRepository $bookRepository The book repository
     * @return Response Returns a JSON response with all books.
     */
    #[Route('proj/api/library/books', name: 'book_json_show_all_proj')]
    public function showAllBooksProj(
        ProjectBookRepository $bookRepository
    ): Response {
        $books = $bookRepository
            ->findAll();

        $response = $this->json($books);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    /**
     * Retrieve a book by ISBN in JSON format
     * @Route("/api/library/books/{isbn}", name="book_json_view_isbn")
     * @param ProjectBookRepository $bookRepository The book repository
     * @param string $isbn The ISBN of the book
     * @return Response Returns a JSON response with the book data or an error message if not found.
     */
    #[Route('proj/api/library/books/{isbn}', name: 'book_json_view_isbn_proj')]
    public function viewJSONBookWithISBNProj(
        ProjectBookRepository $bookRepository,
        string $isbn
    ): Response {
        $book = $bookRepository->findByISBN($isbn);

        if (!$book) {
            return $this->json(['error' => 'Book not found'], Response::HTTP_NOT_FOUND);
        }

        $response = $this->json($book);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
}
