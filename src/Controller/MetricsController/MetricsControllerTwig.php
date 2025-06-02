<?php

namespace App\Controller\MetricsController;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MetricsControllerTwig
 * @package App\Controller
 *
 * This controller handles the metrics-route.
 */
class MetricsControllerTwig extends AbstractController
{
    /**
     * Metrics route
     *
     * @Route("/metrics", name="metrics")
     * @return Response Returns the rendered view of the metrics.html.twig template.
     */
    #[Route("/metrics", name: "metrics")]
    public function metrics(): Response
    {
        return $this->render('metrics.html.twig');
    }

}
