<?php

namespace App\Controller;

use App\Repository\GameRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(
        UserRepository $userRepository,
        GameRepository $gameRepository,
    ): Response {
        $scoringPlayer = $userRepository->maxScoringGamesPlayer();
        $lastGames = $gameRepository->findBy([], ['id' => "ASC"], 2);
        $sumMaxScorePlayer = [];

        foreach ($scoringPlayer as $user) {
            if (array_key_exists($user['username'], $sumMaxScorePlayer)) {
                $sumMaxScorePlayer[$user['username']] += $user['ScoreMax'];
            } else {
                $sumMaxScorePlayer[$user['username']] = $user['ScoreMax'];
            }
        }
        arsort($sumMaxScorePlayer);
        $arrayUsersScoring = [];
        $indexArray = 0;
        foreach ($sumMaxScorePlayer as $username => $score) {
            $arrayUsersScoring[$indexArray]['username'] = $username;
            $arrayUsersScoring[$indexArray]['score'] = $score;
            $indexArray++;
        }


        return $this->render('home/index.html.twig', [
            "arrayUsersScoring" => $arrayUsersScoring,
            "lastGames" => $lastGames,
        ]);
    }
}
