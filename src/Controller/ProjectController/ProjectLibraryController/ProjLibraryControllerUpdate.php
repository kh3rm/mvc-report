<?php

namespace App\Controller\ProjectController\ProjectLibraryController;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\ProjectBookRepository;

/**
 * Class ProjLibraryControllerUpdate
 * @package App\Controller
 *
 * This controller handles the library-update-routes.
 */
final class ProjLibraryControllerUpdate extends AbstractController
{
    /**
     * Update book route
     * @Route("/book/update", name="book_update", methods={"POST"})
     * @param ProjectBookRepository $bookRepository The book repository to find books.
     * @param Request $request The request object.
     * @param ManagerRegistry $doctrine The doctrine manager registry.
     * @return Response Redirects to the book view all route after updating the book.
     */
    #[Route('proj/library/update', name: 'book_update_proj', methods: ['POST'])]
    public function updateBookProj(
        ProjectBookRepository $bookRepository,
        Request $request,
        ManagerRegistry $doctrine
    ): Response {

        $entityManager = $doctrine->getManager();

        $bookISBN = (string) $request->request->get('isbn');

        $book = $bookRepository->findByISBN($bookISBN);

        if (!$book) {
            return new Response('Book not found', Response::HTTP_NOT_FOUND);
        }

        $title = (string) $request->request->get('title');
        $author = (string) $request->request->get('author');
        $isbn = (string) $request->request->get('isbn');
        $imageSource = (string) $request->request->get('image_source');

        $book[0]->setTitle($title);
        $book[0]->setAuthor($author);
        $book[0]->setIsbn($isbn);
        $book[0]->setImgsource($imageSource);

        $entityManager->flush();

        return $this->redirectToRoute('book_view_all_proj');
    }

    /**
     * View update book route by ISBN
     * @Route("/library/update/{isbn}", name="book_update_isbn")
     * @param ProjectBookRepository $bookRepository The book repository to find books.
     * @param string $isbn The ISBN of the book to update.
     * @return Response Renders the view for editing the specified book.
     */
    #[Route('proj/library/update/{isbn}', name: 'book_update_isbn_proj')]
    public function updateBookWithISBN(
        ProjectBookRepository $bookRepository,
        string $isbn
    ): Response {
        $books = $bookRepository->findByISBN($isbn);

        $data = [
            'books' => $books
        ];

        return $this->render('project/library/update.html.twig', $data);
    }
}
