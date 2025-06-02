<?php

namespace App\Controller\SessionController;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Class SessionControllerTwig
 * @package App\Controller
 *
 * This controller handles the session-routes.
 */
class SessionControllerTwig extends AbstractController
{
    /**
     * Session route
     * @Route("/session", name="session")
     * @return Response Returns the rendered view of the session.html.twig-template with session data.
     */
    #[Route("/session", name: "session")]
    public function session(SessionInterface $session): Response
    {
        return $this->render('session.html.twig', [
            'session' => $session->all()
        ]);
    }

    /**
     * Session delete route
     * @Route("/session/delete", name="session-delete")
     * @return Response Returns the rendered view of the session.html.twig-template with cleared session data.
     */
    #[Route("/session/delete", name: "session-delete")]
    public function sessionDelete(SessionInterface $session): Response
    {

        $session->clear();

        $this->addFlash(
            'notice',
            'The session has been deleted!'
        );

        return $this->render('session.html.twig', [
            'session' => $session->all()
        ]);
    }
}
