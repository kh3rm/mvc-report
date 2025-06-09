<?php

namespace App\Controller\ProjectController\ProjectLibraryController;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\ProjectBookRepository;

/**
 * Class LibraryControllerDelete
 * @package App\Controller
 *
 * This controller handles the library-delete-routes.
 */
final class ProjLibraryControllerDelete extends AbstractController
{
    /**
     * Delete book route
     * @Route("/book/delete", name="book_delete", methods={"POST"})
     * @param ProjectBookRepository $bookRepository The book repository to find books.
     * @param Request $request The request object.
     * @param ManagerRegistry $doctrine The doctrine manager registry.
     * @return Response Redirects to the book view all route after deleting the book.
     */
    #[Route('proj/library/delete', name: 'proj_book_delete', methods: ['POST'])]
    public function deleteBookProj(
        ProjectBookRepository $bookRepository,
        Request $request,
        ManagerRegistry $doctrine
    ): Response {
        $entityManager = $doctrine->getManager();
        $bookISBN = (string) $request->request->get('isbn');

        $book = $bookRepository->findByISBN($bookISBN);

        $entityManager->remove($book[0]);
        $entityManager->flush();

        return $this->redirectToRoute('book_view_all_proj');
    }

    /**
     * View delete book route by ISBN
     * @Route("/library/delete/{isbn}", name="delete_book_view_isbn")
     * @param ProjectBookRepository $bookRepository The book repository to find books.
     * @param string $isbn The ISBN of the book to delete.
     * @return Response Renders the view for confirming the delete of the specified book.
     */
    #[Route('proj/library/delete/{isbn}', name: 'delete_book_view_isbn_proj')]
    public function viewDeletebookWithISBN(
        ProjectBookRepository $bookRepository,
        string $isbn
    ): Response {
        $books = $bookRepository->findByISBN($isbn);

        $data = [
            'books' => $books
        ];

        return $this->render('project/library/delete_book.html.twig', $data);
    }
}
