<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReportControllerTwig extends AbstractController
{
    #[Route("/lucky", name: "lucky")]
    public function number(): Response
    {
        $number = random_int(0, 100);

        $fruitArray = ["🍎 apple","🍇 grapes","🍌 banana","🍐 pear","🍊 orange","🍒 cherry",
        "🍓 strawberry","🥝 kiwi","🍍 pineapple","🥭 mango","🍑 peach", "🍉 watermelon"];

        $randomFruitNumber = random_int(0, count($fruitArray) - 1);
        $randomFruit = $fruitArray[$randomFruitNumber];
        $data = [
            'number' => $number,
            'randomFruit' => $randomFruit
        ];

        return $this->render('lucky.html.twig', $data);
    }


    #[Route("/", name: "home")]
    public function home(): Response
    {
        return $this->render('home.html.twig');
    }


    #[Route("/about", name: "about")]
    public function about(): Response
    {
        return $this->render('about.html.twig');
    }

    #[Route("/report", name: "report")]
    public function report(): Response
    {
        return $this->render('report.html.twig');
    }

    #[Route("/api", name: "api")]
    public function api(): Response
    {
        return $this->render('api.html.twig');
    }
}
