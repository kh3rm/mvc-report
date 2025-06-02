<?php

namespace App\Controller\LibraryController;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class LuckyControllerTwig
 * @package App\Controller
 *
 * This controller handles the libraty-home-route.
 */
class LibraryControllerHome extends AbstractController
{
    /**
     * Library route
     *
     * @Route("/library", name="librarylp")
     * @return Response Returns the rendered view of the book/library index.html.twig template.
     */
    #[Route("/library", name: "librarylp")]
    public function library(): Response
    {
        return $this->render('book/index.html.twig');
    }
}
