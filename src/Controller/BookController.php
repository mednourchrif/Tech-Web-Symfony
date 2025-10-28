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
use App\Service\AuthorMailerService;

// Déclaration de class BookController w dima lezm les classes mte3na extends AbstractController
final class BookController extends AbstractController
{
    // Route: /book ya3ni l'adresse mt3na bch nod5lou lil fonction hedhi fl navigateur
    #[Route('/book', name: 'app_book')]
    public function index(): Response
    {
        // Yraja3 template Twig de base mte3 book
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }

    // Route: /book/add bch yzid book jdid b formulaire
    #[Route('/book/add', name: 'app_book_add')]
    public function addBook(Request $request, EntityManagerInterface $entityManager, AuthorMailerService $authorMailer): Response
    {
        // Création instance jdida mte3 Book
        $book = new Book();
        
        // Création formulaire b Type mte3ou BookType
        $form = $this->createForm(BookType::class, $book);

        // ye5ou l request feha les données l 7atinehum kol ml formulaire mte3na
        $form->handleRequest($request);
        
        // Ken formulaire valide w submitted
        if ($form->isSubmitted() && $form->isValid()) {
            // Y7ot l book fi base de données
            $entityManager->persist($book);
            
            // Ysauvegardi fi base de données
            $entityManager->flush();

            // y3ayet lil fonction notifyAuthor() ml class AuthorMailerService
            $authorMailer->notifyAuthor();

            // Yredirecti lil route mte3 affichage
            return $this->redirectToRoute('app_book_affiche');
        }

        // Yraja3 template Twig b formulaire (soit au premier accès, soit si erreurs)
        return $this->render('book/add.html.twig', [
            'form' => $form->createView(), // Convertit le formulaire pour Twig
        ]);
    }

    // Route: /books bch yaffichi liste mt3 books b categories w published/unpublished
    #[Route('/books', name: 'app_books')]
    public function books(BookRepository $bookRepository): Response
    {
        // Ye5ou liste mte3 books ili colonne published = true men base de données
        $publishedbooks = $bookRepository->findBy(['published' => true]);
        // Ye5ou liste mte3 books ili colonne published = false men base de données
        $unpublishedbooks = $bookRepository->findBy(['published' => false]);
        // Ye5ou nombre mte3 books ili colonne category = romance men base de données ( countBooksByRomanceCategory() 5demneha a7na fl BookRepository)
        $romanceCount = $bookRepository->countBooksByRomanceCategory();

        // Yraja3 template Twig b liste mt3 books w statistics
        return $this->render('book/books.html.twig', [
            'publishedbooks' => $publishedbooks,
            'unpublishedbooks' => $unpublishedbooks,
            'romanceCount' => $romanceCount,
        ]);
    }

    // Route: /book/affiche bch yaffichi liste kol books w statistics
    #[Route('/book/affiche', name: 'app_book_affiche')]
    public function afficheBook(BookRepository $bookRepository): Response
    {
        // Ye5ou liste mte3 tous les books men base de données
        $books = $bookRepository->findAll();
        // declaration compteur published_count w unpublished_count
        $published_count = 0;
        $unpublished_count = 0;
        // Ye5ou nombre mte3 books b category romance ( countBooksByRomanceCategory() 5demneha a7na fl BookRepository)
        $romanceCount = $bookRepository->countBooksByRomanceCategory();
        
        // Y7seb nombre mte3 published w unpublished books
        foreach ($books as $book) {
            if ($book->isPublished()) { $published_count++;} 
            else { $unpublished_count++;} 
        }
        // Yraja3 template Twig b liste books w les données lo5rin kima ( published_count, unpublished_count, romanceCount)
        return $this->render('book/affiche.html.twig', [
            'books' => $books,
            'nb_published' => $published_count,
            'nb_unpublished' => $unpublished_count,
            'romanceCount' => $romanceCount,
        ]);
    }

    // Route: /book/edit/{id} bch ymodifi book fl base de données
    #[Route('/book/edit/{id}', name: 'app_book_edit')]
    public function editBook(Request $request, Book $book, EntityManagerInterface $entityManager): Response
    {
        // Création formulaire b Type mte3ou BookType w données mte3 book
        $form = $this->createForm(BookType::class, $book);

        // ye5ou l request feha les données l 7atinehum kol ml formulaire mte3na
        $form->handleRequest($request);

        // Ken formulaire valide w submitted
        if ($form->isSubmitted() && $form->isValid()) {
            // Ysauvegardi l modification fi base de données
            $entityManager->flush();

            // Yredirecti lil route mte3 affichage
            return $this->redirectToRoute('app_book_affiche');
        }

        // Yraja3 template Twig b formulaire w book
        return $this->render('book/edit.html.twig', [
            'form' => $form->createView(),
            'book' => $book,
        ]);
    }

    // Route: /book/delete/{id} bch yfas5 book ml base de données
    #[Route('/book/delete/{id}', name: 'app_book_delete')]
    public function deleteBook(Book $book, EntityManagerInterface $entityManager): Response
    {
        // Yfas5 l book ml base de données
        $entityManager->remove($book);
        $entityManager->flush();

        // Yredirecti lil route mte3 affichage
        return $this->redirectToRoute('app_book_affiche');
    }

    // Route: /book/category/{category} bch yaffichi books b category spécifique
    #[Route('/book/category/{category}', name: 'app_book_category')]
    public function categoryBook($category, BookRepository $bookRepository): Response
    {
        // Ye5ou liste mte3 books b category spécifique ( findBooksByCategory( n7otou parametre f westha ism l category ili bch nlawjou 3leha) 5demneha a7na fl BookRepository)
        $books = $bookRepository->findBooksByCategory($category);
        
        // Yraja3 template Twig b liste books w category
        return $this->render('book/category.html.twig', [
            'books' => $books,
            'category' => $category,
        ]);
    }
}