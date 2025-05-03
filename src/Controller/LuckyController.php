<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LuckyController
{
    #[Route('/lucky/number')]
    public function number(): Response
    {
        $number = random_int(0, 100);

        return new Response(
            '<html><body>
            <h1>
            Wheel of fortune
            </h1>
            <h2><i>Lucky number:</h2>

            <h2>'.$number.' </i></h2>
            <h2>☝</h2>
            </body></html>'
        );
    }


    #[Route("/lucky/hi")]
    public function hello(): Response
    {
        return new Response(
            '<html><body>
            <h1>
            📣
            </h1>
            <h2>
            Hi to you, sir/madam!</body></html>
            </h2>'
        );
    }
}
