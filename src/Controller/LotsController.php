<?php

namespace App\Controller;

use App\Entity\Lot;
use App\Form\WinLotType;
use App\Repository\LotRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/lots', name: 'Lots_')]
class LotsController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(
        LotRepository $lotsRepository,
        UserRepository $userRepository,
        Request $request,
        EntityManagerInterface $entityManager,
    ): Response {
        $lots = $lotsRepository->findAll();
        $sumMaxPlayer = null;
        $lotsAcquired = [];
        $formLots = $this->createForm(WinLotType::class);
        $formLots->handleRequest($request);

        if ($this->getUser()) {
            $scoringPlayer = $userRepository->maxScorinPlayer($this->getUser());
            $sumMaxPlayer = [ 'username' => "", "scoreMax" => 0
            ];
            foreach ($scoringPlayer as $scoreMax) {
                $sumMaxPlayer['username'] = $scoreMax['username'];
                $sumMaxPlayer['scoreMax'] += $scoreMax['ScoreMax'];
            }
            foreach ($this->getUser()->getLots() as $lot) {
                $lotsAcquired[] += $lot->getPrice();
            }

            if ($formLots->isSubmitted() && $formLots->isValid()) {
                $priceLot = (integer)($request->request->get('price'));
                
                $lotsPalier = $lotsRepository->findBy(['price' => $priceLot]);
                $lotsWin = $lotsPalier[array_rand($lotsPalier)];
                $lotAcquired = false;
                foreach ($this->getUser()->getLots() as $lot) {
                    if ($lot->getPrice() === $priceLot) {
                        $lotAcquired = true;
                    }
                }

                if (!$lotAcquired) {
                    $this->getUser()->addLot($lotsWin);
                    $entityManager->flush();
                }
                
                return $this->render('lots/win.html.twig', [
                    'lotWin' => $lotsWin,
                ]);
            }
        }

        return $this->render('lots/index.html.twig', [
            'lots' => $lots,
            'sumMaxPlayer' => $sumMaxPlayer,
            'lotsAcquired' => $lotsAcquired,
            'formLots' => $formLots
        ]);
    }
}
