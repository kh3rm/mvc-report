<?php

namespace App\Controller\LibraryController;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\BookRepository;

/**
 * Class LibraryControllerReset
 * @package App\Controller
 *
 * This controller handles the library-reset-route.
 */
final class LibraryControllerReset extends AbstractController
{
    /**
     * Library Reset Route
     *
     * @Route("/library/reset", name="book_reset")
     * @return Response Resets the content of the book-table to the initial books.
     */
    #[Route('/library/reset', name: 'book_reset')]
    public function resetBooks(
        BookRepository $bookRepository
    ): Response {
        $bookRepository->resetToInitialBooks();


        return $this->redirectToRoute('book_view_all');
    }
}
