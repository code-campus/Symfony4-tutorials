<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/api", name="books:api")
 */
class BookController extends AbstractController
{
    /**
     * @Route("/books.json", name=":index", methods={"GET"})
     */
    public function index(BookRepository $bookRepository): Response
    {
        return $this->json( $bookRepository->findAll() );
    }

    /**
     * @Route("/books.json", name=":new", methods={"POST"})
     */
    public function new(Request $request): Response
    {
        $book = new Book();

        $data = \json_decode($request->getContent(), true);

        foreach ($data as $key => $value)
        {
            $property = ucfirst($key);
            $property = 'set'.$property;

            $book->$property($value);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($book);
        $em->flush();

        return $this->json( $book );
    }

    /**
     * @Route("/books/{id}.json", name="show", methods={"GET"})
     */
    public function show(Book $book): Response
    {
        return $this->json( $book );
    }

    /**
     * @Route("/books/{id}.json", name="edit", methods={"PUT"})
     */
    public function edit(Request $request, Book $book): Response
    {
        $data = \json_decode($request->getContent(), true);

        foreach ($data as $key => $value)
        {
            $property = ucfirst($key);
            $property = 'set'.$property;

            $book->$property($value);
        }

        $this->getDoctrine()->getManager()->flush();

        return $this->json( $book );
    }

    /**
     * @Route("/books/{id}.json", name="delete", methods={"DELETE"})
     */
    public function delete(Request $request, Book $book): Response
    {
        $bookID = $book->getId();

        $em = $this->getDoctrine()->getManager();
        $em->remove($book);
        $em->flush();

        return $this->json([
            "message" => "Entity ID : ". $bookID ." is deleted"
        ]);
    }
}
