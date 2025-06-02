<?php

namespace App\Controller\ReportController;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ReportControllerTwig
 * @package App\Controller
 *
 * This controller handles the report-route.
 */
class ReportControllerTwig extends AbstractController
{
    #[Route("/report", name: "report")]
    public function report(): Response
    {
        return $this->render('report.html.twig');
    }
}
