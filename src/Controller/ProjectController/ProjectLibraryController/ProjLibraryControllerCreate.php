<?php

namespace App\Controller\ProjectController\ProjectLibraryController;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\ProjectBook;

/**
 * Class LibraryControllerCreate
 * @package App\Controller
 *
 * This controller handles the library-create-routes.
 */
final class ProjLibraryControllerCreate extends AbstractController
{
    /**
     * Create book view route
     * @Route("/library/create", name="create_book")
     * @return Response Returns the rendered view of book/create.html.twig.
     */
    #[Route('proj/library/create', name: 'create_book_proj')]
    public function createProj(): Response
    {
        return $this->render('project/library/create.html.twig');
    }

    /**
     * Create book route
     * @Route("proj/library/create", name="book_create_proj", methods={"POST"})
     * @param Request $request The request object
     * @param ManagerRegistry $doctrine The doctrine manager registry
     * @return Response Redirects to the book view all route after creating a book.
     */
    #[Route('proj/library/create-post', name: 'book_create_proj', methods: ['POST'])]
    public function createBookProj(Request $request, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $title = (string) $request->request->get('title');
        $author = (string) $request->request->get('author');
        $isbn = (string) $request->request->get('isbn');
        $imageSource = (string) $request->request->get('image_source');

        $book = new ProjectBook();
        $book->setTitle($title);
        $book->setAuthor($author);
        $book->setIsbn($isbn);
        $book->setImgsource($imageSource);

        $entityManager->persist($book);
        $entityManager->flush();

        return $this->redirectToRoute('book_view_all_proj');
    }
}
