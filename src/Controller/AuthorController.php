<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorformType;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

final class AuthorController extends AbstractController
{
    #[Route('/author', name: 'app_author')]
    public function index(): Response
    {
        return $this->render('author/index.html.twig', ['controller_name' => 'AuthorController']);
    }

    #[Route('/author/{name}', name: 'show_author')]
    public function showAuthor($name): Response
    {
        return $this->render('author/show.html.twig', ['name' => $name]);
    }

    #[Route('/authorlist', name: 'app_author_list')]
    public function listAuthors(): Response
    {
        $authors = array(
            array('id' => 1, 'picture' => '/images/Victor-Hugo.jpg','username' => 'Victor Hugo', 'email' =>
            'victor.hugo@gmail.com ', 'nb_books' => 100),
            array('id' => 2, 'picture' => '/images/william.jpg','username' => ' William Shakespeare', 'email' =>
            ' william.shakespeare@gmail.com', 'nb_books' => 200 ),
            array('id' => 3, 'picture' => '/images/Taha-Hussein.jpg','username' => 'Taha Hussein', 'email' =>
            'taha.hussein@gmail.com', 'nb_books' => 300),
            );
        return $this->render('author/list.html.twig', ['authors' => $authors]);
    }

    #[Route('/authorDetails/{id}', name: 'author_details')]
    public function authorDetails($id){   
        $authors = array(
            array('id' => 1, 'picture' => '/images/Victor-Hugo.jpg','username' => 'Victor Hugo', 'email' =>
            'victor.hugo@gmail.com ', 'nb_books' => 100),
            array('id' => 2, 'picture' => '/images/william.jpg','username' => ' William Shakespeare', 'email' =>
            ' william.shakespeare@gmail.com', 'nb_books' => 200 ),
            array('id' => 3, 'picture' => '/images/Taha-Hussein.jpg','username' => 'Taha Hussein', 'email' =>
            'taha.hussein@gmail.com', 'nb_books' => 300),
        );
        foreach ($authors as $auth) {
            if ($auth['id'] == $id) {
                return $this->render('author/showAuthor.html.twig', ['author' => $auth]);
            }
        }
    }

    #[Route('/show', name: 'app_showauthor')]
    public function Show(AuthorRepository $authorRepository){
        $list = $authorRepository->findAll();
        return $this->render('author/affiche.html.twig', ['author' => $list]);
    }

    #[Route('/addstatique', name: 'app_addstat')]
    public function addStatique(EntityManagerInterface $entityManager){
        $author = new Author();
        $author->setUsername('Mohamed Nour Cherif');
        $author->setEmail('nourchrif004@gmail.com');
        $entityManager->persist($author);
        $entityManager->flush();
        return $this->redirectToRoute('app_showauthor');
    }
    #[Route('/add', name: 'app_addauthor')]
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $Author = new Author();
        $form = $this->createForm(AuthorformType::class, $Author);
        $form->add('submit', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($Author);
            $entityManager->flush();
            return $this->redirectToRoute('app_showauthor');
        }
        return $this->render('author/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/edit/{id}', name: 'author_edit')]
    public function edit(Request $request, Author $author, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AuthorformType::class, $author);
        $form->add('submit', SubmitType::class);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Author updated successfully!');
            return $this->redirectToRoute('app_showauthor');
        }

        return $this->render('author/edit.html.twig', [
            'form' => $form->createView(),
            'author' => $author,
        ]);
    }

    #[Route('/delete/{id}', name:'author_delete')]
    public function delete(Author $author, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($author);
        $entityManager->flush();
        return $this->redirectToRoute('app_showauthor');
    }
}