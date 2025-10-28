<?php

namespace App\Controller;

use App\Service\BookManagerService;
use App\Service\HappyQuote;
use App\Entity\Author;
use App\Form\AuthorformType;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

// Déclaration de class AuthorController w dima lezm les classes mte3na extends AbstractController
final class AuthorController extends AbstractController
{
    // Route: /author ya3ni l'adresse mt3na bch nod5lou lil fonction hedhi fl navigateur
    #[Route('/author', name: 'app_author')]
    public function index(): Response
    {
        // Yraja3 template Twig de base mte3 author
        return $this->render('author/index.html.twig', ['controller_name' => 'AuthorController']);
    }

    // Route: /author/{name} hne name hia variable bch t7ot esm author f lien mte3na
    #[Route('/author/{name}', name: 'show_author')]
    public function showAuthor($name): Response
    {
        // Yraja3 template Twig b esm l'auteur
        return $this->render('author/show.html.twig', ['name' => $name]);
    }

    // Route: /authorlist bch yaffichi liste statique mt3 authors
    #[Route('/authorlist', name: 'app_author_list')]
    public function listAuthors(): Response
    {
        // Tableau fih exemples mt3 authors b données statiques
        $authors = array(
            array('id' => 1, 'picture' => '/images/Victor-Hugo.jpg','username' => 'Victor Hugo', 'email' =>
            'victor.hugo@gmail.com ', 'nb_books' => 100),
            array('id' => 2, 'picture' => '/images/william.jpg','username' => ' William Shakespeare', 'email' =>
            ' william.shakespeare@gmail.com', 'nb_books' => 200 ),
            array('id' => 3, 'picture' => '/images/Taha-Hussein.jpg','username' => 'Taha Hussein', 'email' =>
            'taha.hussein@gmail.com', 'nb_books' => 300),
            );
        // Yraja3 template Twig b liste mt3 les authors mte3na
        return $this->render('author/list.html.twig', ['authors' => $authors]);
    }

    // Route: /authorDetails/{id} hne id hia variable bch t7ot id mte3 author f lien mte3na
    #[Route('/authorDetails/{id}', name: 'author_details')]
    public function authorDetails($id){   
        // Nafs l tableau mte3 authors
        $authors = array(
            array('id' => 1, 'picture' => '/images/Victor-Hugo.jpg','username' => 'Victor Hugo', 'email' =>
            'victor.hugo@gmail.com ', 'nb_books' => 100),
            array('id' => 2, 'picture' => '/images/william.jpg','username' => ' William Shakespeare', 'email' =>
            ' william.shakespeare@gmail.com', 'nb_books' => 200 ),
            array('id' => 3, 'picture' => '/images/Taha-Hussein.jpg','username' => 'Taha Hussein', 'email' =>
            'taha.hussein@gmail.com', 'nb_books' => 300),
        );
        // Ysearchi fi l tableau 3al author li 3andou nafs l id
        foreach ($authors as $auth) {
            if ($auth['id'] == $id) {
                // Yraja3 template Twig b details mte3 author
                return $this->render('author/showAuthor.html.twig', ['author' => $auth]);
            }
        }
    }

    // Route: /show bch yaffichi liste mt3 authors men base de données
    #[Route('/show', name: 'app_showauthor')]
    public function Show(AuthorRepository $authorRepository, HappyQuote $happyQuote, BookManagerService $bookManager){
        // Ye5ou liste mte3 authors men base de données b findAll() ili hia prédéfini fl authorRepository
        $list = $authorRepository->findAll();
        // Yraja3 template Twig b liste mt3 authors mte3na w message ili tab3thou fonction getHappyMessage() ml class happyQuote w liste mte3 best authors ( l classes iili chnjibou menhum lkol n7otouhum fl parametres mt3 fonction mte3na)
        return $this->render('author/affiche.html.twig', [
            'author' => $list, 
            'happyQuote' => $happyQuote->getHappyMessage(),
            'bestAuthors' => $bookManager->bestAuthors(3)
        ]);
    }

    // Route: /addstatique bch yzid author statique (données statiques) fi base de données
    #[Route('/addstatique', name: 'app_addstat')]
    public function addStatique(EntityManagerInterface $entityManager){
        // Création instance jdida mte3 Author
        $author = new Author();
        // Seti esm w email mte3 author
        $author->setUsername('Mohamed Nour Cherif');
        $author->setEmail('nourchrif004@gmail.com');
        // y7ot l author fi base de données
        $entityManager->persist($author);
        $entityManager->flush();
        // yarja3 lil route mte3 affichage
        return $this->redirectToRoute('app_showauthor');
    }

    // Route: /add bch yzid author b formulaire
    #[Route('/add', name: 'app_addauthor')]
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Création instance jdida mte3 Author
        $Author = new Author();
        // Création formulaire b Type mte3ou AuthorformType
        $form = $this->createForm(AuthorformType::class, $Author);
        // Zeyedna bouton submit
        $form->add('submit', SubmitType::class);
        // ye5ou l request feha les données l 7atinehum kol ml formulaire mte3na
        $form->handleRequest($request);
        // Ken formulaire valide w submitted
        if ($form->isSubmitted() && $form->isValid()) {
            // Y7ot l author fi base de données
            $entityManager->persist($Author);
            $entityManager->flush();
            // yarja3 lil route mte3 affichage
            return $this->redirectToRoute('app_showauthor');
        }
        // Yraja3 template Twig b formulaire
        return $this->render('author/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    // Route: /edit/{id} bch ymodifi author fl base de données
    #[Route('/edit/{id}', name: 'author_edit')]
    public function edit(Request $request, Author $author, EntityManagerInterface $entityManager): Response
    {
        // Création formulaire b Type mte3ou AuthorformType w données mte3 author
        $form = $this->createForm(AuthorformType::class, $author);
        $form->add('submit', SubmitType::class);
        
        // ye5ou l request feha les données l 7atinehum kol ml formulaire mte3na
        $form->handleRequest($request);

        // Ken formulaire valide w submitted
        if ($form->isSubmitted() && $form->isValid()) {
            // Ysauvegardi l modification fi base de données
            $entityManager->flush();

            // Yzid message flash bch yaffichi success
            $this->addFlash('success', 'Author updated successfully!');
            // Yredirecti lil route mte3 affichage
            return $this->redirectToRoute('app_showauthor');
        }

        // Yraja3 template Twig b formulaire w author
        return $this->render('author/edit.html.twig', [
            'form' => $form->createView(),
            'author' => $author,
        ]);
    }

    // Route: /delete/{id} bch yfas5 author ml base de données
    #[Route('/delete/{id}', name:'author_delete')]
    public function delete(Author $author, EntityManagerInterface $entityManager): Response
    {
        // Yfas5 l author ml base de données
        $entityManager->remove($author);
        $entityManager->flush();
        // Yredirecti lil route mte3 affichage
        return $this->redirectToRoute('app_showauthor');
    }
}