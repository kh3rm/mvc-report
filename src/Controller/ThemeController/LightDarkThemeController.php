<?php

namespace App\Controller\ThemeController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class LightDarkThemeController
 * @package App\Controller
 *
 * This controller handles the dark/light-theme toggling.
 */
class LightDarkThemeController extends AbstractController
{
    /**
     * Toggle the style theme between light and dark.
     *
     * @Route("/toggle-theme", name="toggle_theme")
     * @param Request $request The request object.
     * @param SessionInterface $session The session interface.
     * @return Response Redirect response to the previous route or home.
     */
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
