<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

// Déclaration de class ArticleController w dima lezm les classes mte3na extends AbstractController
final class ArticleController extends AbstractController
{
    // Route: /article ya3ni l'adresse mt3na bch nod5lou lil fonction hedhi fl navigateur hia 127.0.0.1:8000/article W name: app_article ya3ni le nom mt3na bch najmou narj3ou lil page hedhi ( identifiant mte3 l fonction)
    #[Route('/article', name: 'app_article')]
    public function index(): Response
    {
        // Yraja3 template Twig b liste mt3 les articles mte3na
        return $this->render('article/index.html.twig', [
            'title' => 'Article',           // Titre de la page
            'controller_name' => 'ArticleController', // Nom du contrôleur pour référence
        ]);
    }

    #[Route('/articles', name: 'app_articles')]
    public function articles(): Response
    {
        // Tableau fih exemples mt3 articles
        $articles = [
            [
                'title' => 'Article 1',
                'image' => '/images/img.png',
                'price' => 100
            ],
            [
                'title' => 'Article 2', 
                'image' => '/images/img.png', 
                'price' => 200
            ],
            [
                'title' => 'Article 3', 
                'image' => '/images/img.png', 
                'price' => 300
            ],
        ];
        
        // Yraja3 template Twig b liste mt3 les articles mte3na
        return $this->render('article/articles.html.twig', [
            'articles' => $articles, // Passage articles au template twig
        ]);
    }
}