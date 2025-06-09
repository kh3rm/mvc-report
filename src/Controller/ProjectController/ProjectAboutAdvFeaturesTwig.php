<?php

namespace App\Controller\ProjectController;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * About Advanced Features Database-Controller
 * @package App\Controller
 *
 * This controller handles the about-advanced-features-route.
 */
class ProjectAboutAdvFeaturesTwig extends AbstractController
{
    #[Route("/proj/about/advanced-features", name: "about_advf_proj")]
    public function report(): Response
    {
        return $this->render('/project/about-advanced-features.html.twig');
    }
}
