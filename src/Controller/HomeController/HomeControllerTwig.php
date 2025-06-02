<?php

namespace App\Controller\HomeController;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HomeControllerTwig
 * @package App\Controller
 *
 * This controller handles the home-route.
 */
class HomeControllerTwig extends AbstractController
{
    /**
     * Home route
     *
     * @Route("/", name="home")
     * @return Response Returns the rendered view of the home.html.twig-template.
     */
    #[Route("/", name: "home")]
    public function home(): Response
    {
        return $this->render('home.html.twig');
    }
}
