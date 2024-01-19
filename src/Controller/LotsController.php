<?php

namespace App\Controller;

use App\Entity\Lots;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\LotRepository;

#[Route('/lots', name: 'Lots_')]
class LotsController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(LotRepository $lotsRepository): Response
    {
        $lots = $lotsRepository->findAll();

        return $this->render('lots/index.html.twig', [
            'lots' => $lots,
        ]);
    }
}
