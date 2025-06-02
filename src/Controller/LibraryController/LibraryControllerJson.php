<?php

namespace App\Controller\LibraryController;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\BookRepository;

/**
 * Class LibraryControllerJson
 * @package App\Controller
 *
 * This controller handles the library-json-routes.
 */
final class LibraryControllerJson extends AbstractController
{
    /**
     * Retrieve all books in JSON format
     * @Route("/api/library/books", name="book_json_show_all")
     * @param BookRepository $bookRepository The book repository
     * @return Response Returns a JSON response with all books.
     */
    #[Route('/api/library/books', name: 'book_json_show_all')]
    public function showAllBooks(
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

    /**
     * Retrieve a book by ISBN in JSON format
     * @Route("/api/library/books/{isbn}", name="book_json_view_isbn")
     * @param BookRepository $bookRepository The book repository
     * @param string $isbn The ISBN of the book
     * @return Response Returns a JSON response with the book data or an error message if not found.
     */
    #[Route('/api/library/books/{isbn}', name: 'book_json_view_isbn')]
    public function viewJSONBookWithISBN(
        BookRepository $bookRepository,
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
