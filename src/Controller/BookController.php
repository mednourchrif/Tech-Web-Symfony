<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\BookRepository;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

final class BookController extends AbstractController
{
    #[Route('/book', name: 'app_book')]
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }

    #[Route('/book/add', name: 'app_book_add')]
    public function addBook(Request $request, EntityManagerInterface $entityManager): Response
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($book);
            $entityManager->flush();

            return $this->redirectToRoute('app_book_affiche');
        }

        return $this->render('book/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/books', name: 'app_books')]
    public function books(BookRepository $bookRepository): Response
    {
        $publishedbooks = $bookRepository->findBy(['published' => true]);
        $unpublishedbooks = $bookRepository->findBy(['published' => false]);
        $romanceCount = $bookRepository->countBooksByRomanceCategory();

        return $this->render('book/books.html.twig', [
            'publishedbooks' => $publishedbooks,
            'unpublishedbooks' => $unpublishedbooks,
            'romanceCount' => $romanceCount,
        ]);
    }

    #[Route('/book/affiche', name: 'app_book_affiche')]
    public function afficheBook(BookRepository $bookRepository): Response
    {
        $books = $bookRepository->findAll();
        $published_count = 0;
        $unpublished_count = 0;
        $romanceCount = $bookRepository->countBooksByRomanceCategory();
        
        foreach ($books as $book) {
            if ($book->isPublished()) { $published_count++;} 
            else { $unpublished_count++;} 
        }
        return $this->render('book/affiche.html.twig', [
            'books' => $books,
            'nb_published' => $published_count,
            'nb_unpublished' => $unpublished_count,
            'romanceCount' => $romanceCount,
        ]);
    }

    #[Route('/book/edit/{id}', name: 'app_book_edit')]
    public function editBook(Request $request, Book $book, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BookType::class, $book);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_book_affiche');
        }

        return $this->render('book/edit.html.twig', [
            'form' => $form->createView(),
            'book' => $book,
        ]);
    }

    #[Route('/book/delete/{id}', name: 'app_book_delete')]
    public function deleteBook(Book $book, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($book);
        $entityManager->flush();

        $this->addFlash('success', 'Book deleted successfully!');
        return $this->redirectToRoute('app_book_affiche');
    }

    #[Route('/book/category/{category}', name: 'app_book_category')]
    public function categoryBook($category, BookRepository $bookRepository): Response
    {
        $books = $bookRepository->findBooksByCategory($category);
        
        return $this->render('book/category.html.twig', [
            'books' => $books,
            'category' => $category,
        ]);
    }
}