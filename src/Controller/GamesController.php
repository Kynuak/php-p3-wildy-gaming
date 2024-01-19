<?php

namespace App\Controller;

use App\Repository\GameRepository;
use App\Repository\PlayRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GamesController extends AbstractController
{
    #[Route('/games', name: 'games')]
    public function index(
        GameRepository $gameRepository,
        PlayRepository $playRepository,
    ): Response {

        $games = $gameRepository->findAll();
        $plays = [];
        foreach ($games as $key => $game) {
            $plays[$key] = $playRepository->findBy(['game' => $game->getId()], ['score' => "DESC"], 3);
        }

        return $this->render('games/index.html.twig', [
            'games' => $games,
            'plays' => $plays,
        ]);
    }
}
