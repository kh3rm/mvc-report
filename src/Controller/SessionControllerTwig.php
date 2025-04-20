<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SessionControllerTwig extends AbstractController
{
    #[Route("/session", name: "session")]
    public function session(SessionInterface $session): Response
    {
        return $this->render('session.html.twig', [
            'session' => $session->all()
        ]);
    }


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
