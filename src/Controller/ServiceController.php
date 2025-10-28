<?php

namespace App\Controller;

use App\Service\HappyQuote;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
// Déclaration de class ServiceController w dima lezm les classes mte3na extends AbstractController
final class ServiceController extends AbstractController
{
    // Route: /service ya3ni l'adresse mt3na bch nod5lou lil fonction hedhi fl navigateur
    #[Route('/service', name: 'app_service')]
    public function index(): Response
    {
        // Yraja3 template Twig de base mte3 service
        return $this->render('service/index.html.twig', [
            'controller_name' => 'ServiceController',
        ]);
    }
    // Route: /service/{name}/{id} ya3ni l'adresse mt3na bch nod5lou lil fonction hedhi fl navigateur
    #[Route('/service/{name}/{id}', name: 'app_service_show')]
    public function showservice($name,$id): Response
    {
        // Yraja3 template Twig b esm l'service w id
        return $this->render('service/showservice.html.twig', [
            'name' => $name,
            'id' => $id,
        ]);
    }
    // Route: /goToIndex ya3ni l'adresse mt3na bch nod5lou lil fonction hedhi fl navigateur
    #[Route('/goToIndex', name: 'app_service_goToIndex')]
    public function goToIndex(){
        // Yredirecti lil route mte3 index
        return $this->redirectToRoute('app_home');
    }
}