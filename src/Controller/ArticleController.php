<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ArticleController extends AbstractController
{
    #[Route('/article', name: 'app_article')]
    public function index(): Response
    {
        return $this->render('article/index.html.twig', [
            'title' => 'Article',
            'controller_name' => 'ArticleController',
        ]);
    }

    #[Route('/articles', name: 'app_articles')]
    public function articles(): Response
    {
        $articles = [
            ['title' => 'Article 1', 'image' => '/images/img.png', 'price' => 100],
            ['title' => 'Article 2', 'image' => '/images/img.png', 'price' => 200],
            ['title' => 'Article 3', 'image' => '/images/img.png', 'price' => 300],
        ];
        return $this->render('article/articles.html.twig', [
            'articles' => $articles,
        ]);
    }
}