<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/book", name="book_")
 */
class BookController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @param BookRepository $bookRepository
     * @return Response
     */
    public function index(BookRepository $bookRepository)
    {
        return $this->render('book/index.html.twig', [
            'books' => $bookRepository->findBy([], ['author' => 'ASC'])
        ]);
    }

    /**
     * @Route("/createbook", name="create_book")
     */
    public function createBook(): Response
    {
        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to the action: createProduct(EntityManagerInterface $entityManager)
        $entityManager = $this->getDoctrine()->getManager();

        $book = new Book();
        $book->setName('The Grapes of Wrath');
        $book->setAuthor('Steinbeck');
        $book->setYear(1939);

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($book);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new book with id '.$book->getId());
    }
}
