<?php

namespace App\Controller\AboutControllerTwig;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BlackjackGameControllerGET
 * @package App\Controller
 *
 * This controller handles the /about-twig-route.
 */
class AboutControllerTwig extends AbstractController
{
    /**
    * About-route
    *
    * @Route("/about", name="about")
    * @return Response Returns the rendered view of the api.twig-template.
    */
    #[Route("/about", name: "about")]
    public function about(): Response
    {
        return $this->render('about.html.twig');
    }

}
