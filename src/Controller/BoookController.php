<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class BoookController extends AbstractController
{
    #[Route('/boook', name: 'app_boook')]
    public function index(): Response
    {
        return $this->render('boook/index.html.twig', [
            'controller_name' => 'BoookController',
        ]);
    }
}
