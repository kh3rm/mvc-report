<?php

namespace App\Controller\ProjectController;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProjectApiControllerTwig
 * @package App\Controller
 *
 * This controller handles the api-project-twig-route.
 */
class ProjectApiControllerTwig extends AbstractController
{
    /**
     * Api-route
     *
     * @Route("/api", name="api")
     * @return Response Returns the rendered view of the api.twig-template.
     */
    #[Route("proj/api", name: "api_project")]
    public function apiProject(): Response
    {
        return $this->render('project/api.html.twig');
    }
}
