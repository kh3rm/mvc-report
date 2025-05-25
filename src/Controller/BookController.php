<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Book;
use App\Repository\BookRepository;


final class BookController extends AbstractController
{
    #[Route('/book', name: 'app_book')]
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }

    #[Route('/library/create', name: 'create_book')]

    public function create(): Response
    {
        return $this->render('book/create.html.twig');
    }

    #[Route('/book/create', name: 'book_create', methods: ['POST'])]
    public function createBook(Request $request, ManagerRegistry $doctrine): Response {
        $entityManager = $doctrine->getManager();

        $title = $request->request->get('title');
        $author = $request->request->get('author');
        $isbn = $request->request->get('isbn');
        $imageSource = $request->request->get('image_source');

     /*    if (empty($name) || empty($author) || empty($isbn)) {
            return new Response('Invalid input', Response::HTTP_BAD_REQUEST);
        }
 */
        $book = new Book();
        $book->setTitle($title);
        $book->setAuthor($author);
        $book->setIsbn($isbn);
        $book->setImgsource($imageSource);

        $entityManager->persist($book);
        $entityManager->flush();

        return $this->redirectToRoute('book_view_all');
    }

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




    #[Route('/book/update', name: 'book_update', methods: ['POST'])]
    public function updateBook(
        BookRepository $bookRepository,
        Request $request,
        ManagerRegistry $doctrine): Response {

        $entityManager = $doctrine->getManager();
        $bookISBN = $request->request->get('isbn');

        $book = $bookRepository->findByISBN($bookISBN);

        if (!$book) {
            return new Response('Book not found', Response::HTTP_NOT_FOUND);
        }

        $title = $request->request->get('title');
        $author = $request->request->get('author');
        $isbn = $request->request->get('isbn');
        $imageSource = $request->request->get('image_source');

    /*
    if (empty($title) || empty($author) || empty($isbn)) {
        return new Response('Invalid input', Response::HTTP_BAD_REQUEST);
    }
    */

    $book[0]->setTitle($title);
    $book[0]->setAuthor($author);
    $book[0]->setIsbn($isbn);
    $book[0]->setImgsource($imageSource);

    $entityManager->flush();

    return $this->redirectToRoute('book_view_all');
}



    #[Route('/book/delete', name: 'book_delete', methods: ['POST'])]
    public function deleteBook(
        BookRepository $bookRepository,
        Request $request,
        ManagerRegistry $doctrine): Response {

        $entityManager = $doctrine->getManager();
        $bookISBN = $request->request->get('isbn');

        $book = $bookRepository->findByISBN($bookISBN);

        if (!$book) {
            return new Response('Book not found', Response::HTTP_NOT_FOUND);
        }

        $entityManager->remove($book[0]);
        $entityManager->flush();

        return $this->redirectToRoute('book_view_all');
    }



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






    #[Route('/book/show/{id}', name: 'book_by_id')]
    public function showProductById(
        BookRepository $bookRepository,
        int $id
    ): Response {
        $book = $bookRepository
            ->find($id);

        return $this->json($book);
    }


    #[Route('/book/delete/{id}', name: 'book_delete_by_id')]
    public function deletebookById(
        ManagerRegistry $doctrine,
        int $id
    ): Response {
        $entityManager = $doctrine->getManager();
        $book = $entityManager->getRepository(Book::class)->find($id);

        if (!$book) {
            throw $this->createNotFoundException(
                'No book found for id '.$id
            );
        }

        $entityManager->remove($book);
        $entityManager->flush();

        return $this->redirectToRoute('book_show_all');
    }


    #[Route('/library/update/{isbn}', name: 'book_update_isbn')]
    public function updateBookWithISBN(
        BookRepository $bookRepository,
        int $isbn
    ): Response {
        $books = $bookRepository->findByISBN($isbn);

        $data = [
            'books' => $books
        ];

        return $this->render('book/update.html.twig', $data);
    }



    #[Route('/library/view', name: 'book_view_all')]
    public function viewAllBooks(
        BookRepository $bookRepository
    ): Response {
        $books = $bookRepository->findAll();

        $data = [
            'books' => $books
        ];

        return $this->render('book/view.html.twig', $data);
    }




    #[Route('/library/reset', name: 'book_reset')]
    public function resetBooks(
        BookRepository $bookRepository
    ): Response {
        $bookRepository->resetToInitialBooks();


        return $this->redirectToRoute('book_view_all');
    }





    #[Route('/library/view/{isbn}', name: 'book_view_isbn')]
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


    #[Route('/library/delete/{isbn}', name: 'delete_book_view_isbn')]
    public function viewDeletebookWithISBN(
        BookRepository $bookRepository,
        string $isbn
    ): Response {
        $books = $bookRepository->findByISBN($isbn);

        $data = [
            'books' => $books
        ];

        return $this->render('book/delete_book.html.twig', $data);
    }




    #[Route('/book/show/min/{author}', name: 'book_by_min_author')]
    public function showbookByMinimumAuthor(
        BookRepository $bookRepository,
        int $author
    ): Response {
        $books = $bookRepository->findByMinimumAuthor2($author);

        return $this->json($books);
    }

}
