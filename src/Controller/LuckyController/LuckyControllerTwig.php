<?php

namespace App\Controller\LuckyController;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class LuckyControllerTwig
 * @package App\Controller
 *
 * This controller handles the lucky-route.
 */
class LuckyControllerTwig extends AbstractController
{
    /**
     * Lucky-route
     *
     * @Route("/lucky", name="lucky")
     * @return Response Returns the rendered view of the lucky.html.twig template.
     */
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
}
