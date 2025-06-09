<?php

namespace App\Controller\ProjectController;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BlackjackGameControllerGET
 * @package App\Controller
 *
 * This controller handles the /about-twig-route.
 */
class ProjectAboutControllerTwig extends AbstractController
{
    /**
    * Project About-route
    *
    * @Route("proj/about", name="about")
    * @return Response Returns the rendered view of the api.twig-template.
    */
    #[Route("proj/about", name: "proj_about")]
    public function aboutProj(): Response
    {
        return $this->render('project/about.html.twig');
    }

}
