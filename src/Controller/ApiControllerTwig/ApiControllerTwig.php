<?php

namespace App\Controller\ApiControllerTwig;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BlackjackGameControllerGET
 * @package App\Controller
 *
 * This controller handles the /api-twig-route.
 */
class ApiControllerTwig extends AbstractController
{
    /**
     * Api-route
     *
     * @Route("/api", name="api")
     * @return Response Returns the rendered view of the api.twig-template.
     */
    #[Route("/api", name: "api")]
    public function api(): Response
    {
        return $this->render('api.html.twig');
    }
}
