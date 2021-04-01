<?php
declare(strict_types=1);
/**
 * File: JoinesController.php
 *
 * @author    Michal Broniszewski <michal.broniszewski@lizardmedia.pl>
 * @copyright Copyright (C) 2018 Lizard Media (http://lizardmedia.pl)
 */

namespace App\Controller;

use App\Entity\Game;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class JoinesController
 * @package App\Controller
 * @Route("/joines")
 */
class JoinesController extends Controller
{
    /**
     * @Route("game/join/{id}", name="joines_join")
     * @param Game $game
     * @return JsonResponse
     */
    public function join(Game $game)
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();

        if (!$currentUser instanceof User) {
            return new JsonResponse(
                [],
                Response::HTTP_UNAUTHORIZED
            );
        }

        $game->join($currentUser);
        $this->getDoctrine()->getManager()->flush();

        return new JsonResponse([
            'count' => $game->getJoinedBy()->count()
        ]);
    }

    /**
     * @Route("game/unjoin/{id}", name="unjoines_unjoin")
     * @param Game $game
     * @return JsonResponse
     */
    public function unjoin(Game $game)
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();

        if (!$currentUser instanceof User) {
            return new JsonResponse(
                [],
                Response::HTTP_UNAUTHORIZED
            );
        }

        $game->getJoinedBy()->removeElement($currentUser);
        $this->getDoctrine()->getManager()->flush();

        return new JsonResponse([
            'count' => $game->getJoinedBy()->count()
        ]);
    }
}
