<?php

namespace App\Controller\ProjectController\ProjectSessionController;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Class ProjectSessionController
 * @package App\Controller
 *
 * This controller handles the project-session-routes.
 */
class ProjectSessionController extends AbstractController
{
    /**
     * Session route
     * @Route("/session", name="session")
     * @return Response Returns the rendered view of the session.html.twig-template with session data.
     */
    #[Route("proj/session", name: "session_proj")]
    public function projectSession(SessionInterface $session): Response
    {
        return $this->render('project/project-session.html.twig', [
            'session' => $session->all()
        ]);
    }

    /**
     * Session delete route
     * @Route("/session/delete", name="session-delete")
     * @return Response Returns the rendered view of the session.html.twig-template with cleared session data.
     */
    #[Route("proj/session/delete", name: "session_delete_proj")]
    public function projectSessionDelete(SessionInterface $session): Response
    {

        $session->clear();

        $this->addFlash(
            'notice',
            'The session has been deleted!'
        );

        return $this->render('project/project-session.html.twig', [
            'session' => $session->all()
        ]);
    }
}
