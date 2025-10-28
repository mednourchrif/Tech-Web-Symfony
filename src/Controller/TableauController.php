<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

// Déclaration de class TableauController w dima lezm les classes mte3na extends AbstractController
final class TableauController extends AbstractController
{
    // Route: /tableau ya3ni l'adresse mt3na bch nod5lou lil fonction hedhi fl navigateur
    #[Route('/tableau', name: 'app_tableau')]
    public function index(): Response
    {
        // Yraja3 template Twig de base mte3 tableau
        return $this->render('tableau/index.html.twig', [
            'controller_name' => 'TableauController',
        ]);
    }

    #[Route('/tableau1', name: 'app_tableau1')]
    public function tableau1(): Response
    {
        // Création tableau statique
        $tab = [];
        $tab[0] = 10;
        $tab[1] = 20;
        $tab[2] = 30;

        // Yraja3 template Twig b tableau statique
        return $this->render('tableau/tableau.html.twig', [
            'tab' => $tab,
        ]);
    }
}
