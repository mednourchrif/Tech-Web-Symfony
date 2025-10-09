<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ServiceController extends AbstractController
{
    #[Route('/service', name: 'app_service')]
    public function index(): Response
    {
        return $this->render('service/index.html.twig', [
            'controller_name' => 'ServiceController',
        ]);
    }

    #[Route('/service/{name}+{id}', name: 'app_service_show')]
    public function showservice($name,$id): Response
    {
        return $this->render('service/showservice.html.twig', [
            'name' => $name,
            'id' => $id,
        ]);
    }

    #[Route('/goToIndex', name: 'app_service_goToIndex')]
    public function goToIndex(){
        return $this->redirectToRoute('app_home');
    }
}