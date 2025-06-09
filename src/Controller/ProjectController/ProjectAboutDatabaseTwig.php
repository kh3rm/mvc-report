<?php

namespace App\Controller\ProjectController;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * About Database-Controller
 * @package App\Controller
 *
 * This controller handles the about-databse-route.
 */
class ProjectAboutDatabaseTwig extends AbstractController
{
    #[Route("/proj/about/database", name: "about_database_proj")]
    public function report(): Response
    {
        return $this->render('/project/about-database.html.twig');
    }
}
