<?php

namespace App\Controller\ProjectController;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProjectFreeBirdController
 * @package App\Controller
 *
 * This controller handles the free-bird-route.
 */
class ProjectFreeBirdController extends AbstractController
{
    /**
     * Game Rules-route
     *
     * @Route("proj/free-bird", name="free_bird_project")
     * @return Response Returns the rendered view of the project/free-bird.html.twig
     */
    #[Route("proj/free-bird", name: "free_bird_project")]
    public function freeBirdProject(): Response
    {
        return $this->render('project/free-bird.html.twig');
    }
}
