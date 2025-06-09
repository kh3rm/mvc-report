<?php

namespace App\Controller\ProjectController\ProjectLibraryController;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class LuckyControllerTwig
 * @package App\Controller
 *
 * This controller handles the libraty-home-route.
 */
class ProjLibraryControllerHome extends AbstractController
{
    /**
     * Project Library Route
     *
     * @Route("/library", name="librarylp")
     * @return Response Returns the rendered view of the book/library index.html.twig template.
     */
    #[Route("proj/library", name: "librarylp_proj")]
    public function libraryProj(): Response
    {
        return $this->render('project/library/index.html.twig');
    }
}
