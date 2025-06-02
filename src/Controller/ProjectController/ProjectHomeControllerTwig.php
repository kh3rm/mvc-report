<?php

namespace App\Controller\ProjectController;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class Project-controller
 * @package App\Controller
 *
 * This controller handles the project home-route.
 */
class ProjectHomeControllerTwig extends AbstractController
{
    #[Route("/proj", name: "proj")]
    public function report(): Response
    {
        return $this->render('/project/proj.html.twig');
    }
}
