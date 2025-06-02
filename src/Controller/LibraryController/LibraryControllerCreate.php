<?php

namespace App\Controller\LibraryController;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Book;

/**
 * Class LibraryControllerCreate
 * @package App\Controller
 *
 * This controller handles the library-create-routes.
 */
final class LibraryControllerCreate extends AbstractController
{
    /**
     * Create book view route
     * @Route("/library/create", name="create_book")
     * @return Response Returns the rendered view of book/create.html.twig.
     */
    #[Route('/library/create', name: 'create_book')]
    public function create(): Response
    {
        return $this->render('book/create.html.twig');
    }

    /**
     * Create book route
     * @Route("/book/create", name="book_create", methods={"POST"})
     * @param Request $request The request object
     * @param ManagerRegistry $doctrine The doctrine manager registry
     * @return Response Redirects to the book view all route after creating a book.
     */
    #[Route('/book/create', name: 'book_create', methods: ['POST'])]
    public function createBook(Request $request, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $title = (string) $request->request->get('title');
        $author = (string) $request->request->get('author');
        $isbn = (string) $request->request->get('isbn');
        $imageSource = (string) $request->request->get('image_source');

        $book = new Book();
        $book->setTitle($title);
        $book->setAuthor($author);
        $book->setIsbn($isbn);
        $book->setImgsource($imageSource);

        $entityManager->persist($book);
        $entityManager->flush();

        return $this->redirectToRoute('book_view_all');
    }
}
