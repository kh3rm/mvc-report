<?php

namespace App\Controller\ReportController;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ReportControllerJson
 * @package App\Controller
 *
 * This controller handles the api-quote generation.
 */
class ReportControllerJson
{
    /**
     * Api-quote route
     *
     * @Route("/api/quote", name="api/quote")
     * @return JsonResponse Returns a random Groucho Marx quote.
     */
    #[Route("/api/quote", name: "api/quote")]
    public function apiQuote(): Response
    {
        $number = random_int(0, 42);

        $grouchoQuotes = array(
            "I refuse to join any club that would have me as a member.",
            "Behind every successful man is a woman, behind her is his wife.",
            "One morning I shot an elephant in my pajamas. How he got into my pajamas I'll never know.",
            "Well, Art is Art, isn't it? Still, on the other hand, water is water. And east is east and west is west and if you take cranberries and stew them like applesauce they taste much more like prunes than rhubarb does. Now you tell me what you know.",
            "All people are born alike - except Republicans and Democrats.",
            "No man goes before his time - unless the boss leaves early.",
            "I've had a perfectly wonderful evening. But this wasn't it.",
            "A child of five would understand this. Send someone to fetch a child of five.",
            "Please accept my resignation. I don't care to belong to any club that will have me as a member.",
            "Before I speak, I have something important to say.",
            "Politics doesn't make strange bedfellows - marriage does.",
            "There's one way to find out if a man is honest - ask him. If he says, 'Yes,' you know he is a crook.",
            "I've got the brain of a four year old. I'll bet he was glad to be rid of it.",
            "Military intelligence is a contradiction in terms.",
            "Anyone who says he can see through women is missing a lot.",
            "If I held you any closer I would be on the other side of you.",
            "A woman is an occasional pleasure but a cigar is always a smoke.",
            "Those are my principles, and if you don't like them... well, I have others.",
            "The secret of life is honesty and fair dealing. If you can fake that, you've got it made.",
            "A man's only as old as the woman he feels.",
            "I intend to live forever, or die trying.",
            "I must confess, I was born at a very early age.",
            "Getting older is no problem. You just have to live long enough.",
            "I worked my way up from nothing to a state of extreme poverty.",
            "I'm not feeling very well - I need a doctor immediately. Ring the nearest golf course.",
            "I read in the newspapers they are going to have 30 minutes of intellectual stuff on television every Monday from 7:30 to 8. to educate America. They couldn't educate America if they started at 6:30.",
            "I remember the first time I had sex - I kept the receipt.",
            "Practically everybody in New York has half a mind to write a book, and does.",
            "Alimony is like buying hay for a dead horse.",
            "Next time I see you, remind me not to talk to you.",
            "From the moment I picked your book up until I laid it down, I was convulsed with laughter. Someday I intend reading it.",
            "Quote me as saying I was mis-quoted.",
            "Why, I'd horse-whip you if I had a horse.",
            "Military justice is to justice what military music is to music.",
            "Marry me and I'll never look at another horse!",
            "I was married by a judge. I should have asked for a jury.",
            "I find television very educating. Every time somebody turns on the set, I go into the other room and read a book.",
            "In Hollywood, brides keep the bouquets and throw away the groom.",
            "Outside of a dog, a book is a man's best friend. Inside of a dog it's too dark to read.",
            "Marriage is a wonderful institution, but who wants to live in an institution?",
            "I, not events, have the power to make me happy or unhappy today. I can choose which it shall be. Yesterday is dead, tomorrow hasn't arrived yet. I have just one day, today, and I'm going to be happy in it.",
            "Man does not control his own fate. The women in his life do that for him.",
            "I never forget a face, but in your case I'll be glad to make an exception.",
            "She got her looks from her father. He's a plastic surgeon.",
            "Why should I care about posterity? What's posterity ever done for me?",
            "A black cat crossing your path signifies that the animal is going somewhere.",
            "I must say I find television very educational. The minute somebody turns it on, I go to the library and read a good book.",
            "If you've heard this story before, don't stop me, because I'd like to hear it again.",
            "A hospital bed is a parked taxi with the meter running.",
            "Women should be obscene and not heard.",
            "Humor is reason gone mad.",
            "I have had a perfectly wonderful evening, but this wasn't it.",
            "Whoever named it necking was a poor judge of anatomy."
        );

        $randomGrouchoQuote = $grouchoQuotes[$number];
        $date = date('Y-m-d (l \t\h\e jS \o\f F Y)');
        $timestamp = date('Y-m-d H:i:s');

        $data = [
            'random-groucho-quote' => $randomGrouchoQuote,
            'admin-message' => 'Enjoyed the humour? Reload the page for another quote.',
            'todays-date' => $date,
            'exact-timestamp-of-quote-generation' => $timestamp

        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

}
