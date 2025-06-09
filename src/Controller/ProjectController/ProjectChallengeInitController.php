<?php

namespace App\Controller\ProjectController;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProjectChallengeInitController
 * @package App\Controller
 *
 * This controller handles the /about-twig-route.
 */
class ProjectChallengeInitController extends AbstractController
{
    /**
    * Project About-route
    *
    * @Route("proj/challenge-init", name="challenge_init_proj")
    * @return Response Returns the rendered view of the api.twig-template.
    */
    #[Route("proj/challenge-init", name: "challenge_init_proj")]
    public function challengeInitProj(): Response
    {
        return $this->render('project/challenge-init.html.twig');
    }

}
