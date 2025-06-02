<?php

namespace App\Controller\CardController;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CardControllerDrawTwig
 * @package App\Controller
 *
 * This controller handles the card home-route.
 */
class CardControllerHomeTwig extends AbstractController
{
    /**
     * Library route
     *
     * @Route("/card", name="cardlp")
     * @return Response Returns the rendered view of the card.html.twig template.
     */

    #[Route("/card", name: "cardlp")]
    public function cardLandingPage(): Response
    {
        return $this->render('card.html.twig');
    }
}
