<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Play;
use App\Repository\GameRepository;
use App\Repository\PlayRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/games', name:'games_')]
class GamesController extends AbstractController
{
    #[Route('/', name: 'index')]
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

    #[Route('/{gameSlug}', methods:['GET'], name:'show')]
    public function showGame(
        #[MapEntity(mapping: ['gameSlug' => 'slug'])] Game $game,
        PlayRepository $playRepository,
    ): Response {

        $plays = $playRepository->findBy(["game" => $game->getId()], ["score" => "DESC"]);

        return $this->render('games/show.html.twig', [
            'game' => $game,
            "plays" => $plays
        ]);
    }

    public function saveScore(
        Request $request,
        EntityManagerInterface $entityManager,
        GameRepository $gameRepository,
    ): JsonResponse {

        $score = $request->get("score");
        $nameGame = $request->get("name_game");

        $game = $gameRepository->findOneBy(['slug' => $nameGame]);

        $play = new Play();
        $play->setGame($game);
        $play->setUser($this->getUser());
        $play->setScore($score);
        $play->setDate(new DateTime());

        $entityManager->persist($play);
        $entityManager->flush();

        return new JsonResponse(['success' => true, "score" => $score, "name_game" => $nameGame, "game" => $game]);
    }
}
