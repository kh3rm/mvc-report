<?php

namespace App\Controller\ProjectController\ProjectLibraryController;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ProjectBookRepository;

/**
 * Class rojLibraryControllerReset
 * @package App\Controller
 *
 * This controller handles the library-reset-route.
 */
final class ProjLibraryControllerReset extends AbstractController
{
    /**
     * Library Reset Route
     *
     * @Route("proj/library/reset", name="proj_book_reset")
     * @return Response Resets the content of the book-table to the initial books.
     */
    #[Route('proj/library/reset', name: 'book_reset_proj')]
    public function resetBooksProj(
        ProjectBookRepository $bookRepository
    ): Response {
        $bookRepository->resetToInitialBooks();


        return $this->redirectToRoute('book_view_all_proj');
    }
}
