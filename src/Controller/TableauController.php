<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TableauController extends AbstractController
{
    #[Route('/tableau', name: 'app_tableau')]
    public function index(): Response
    {
        return $this->render('tableau/index.html.twig', [
            'controller_name' => 'TableauController',
        ]);
    }

    #[Route('/tableau1', name: 'app_tableau1')]
    public function tableau1(): Response
    {
        $tab = [];
        $tab[0] = 10;
        $tab[1] = 20;
        $tab[2] = 30;

        return $this->render('tableau/tableau.html.twig', [
            'tab' => $tab,
        ]);
    }
}
