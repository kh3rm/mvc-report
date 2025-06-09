<?php

namespace App\Controller\ProjectController;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class GameControllerRules
 * @package App\Controller
 *
 * This controller handles the game-rules-route.
 */
class ProjectRulesController extends AbstractController
{
    /**
     * Game Rules-route
     *
     * @Route("proj/rules", name="rules_project")
     * @return Response Returns the rendered view of the game/rules.html.twig.
     */
    #[Route("proj/rules", name: "rules_project")]
    public function gameRulesProject(): Response
    {
        return $this->render('project/rules.html.twig');
    }
}
