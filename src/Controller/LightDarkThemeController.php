<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LightDarkThemeController extends AbstractController
{
    #[Route("/toggle-theme", name:"toggle_theme")]
    public function toggleStyleTheme(Request $request, SessionInterface $session): Response
    {
        $currentTheme = $session->get('theme', 'light');
        $updatedTheme = $currentTheme === 'dark' ? 'light' : 'dark';

        $session->set('theme', $updatedTheme);

        $previousRoute = $request->headers->get('referer');

        return $this->redirect($previousRoute ?: $this->generateUrl('home'));
    }
}
