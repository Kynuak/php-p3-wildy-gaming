<?php

namespace App\Controller\Admin;

use App\Entity\Lot;
use App\Form\LotType;
use App\Repository\LotRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/lots', name:'admin_lots_')]
class AdminLotsController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(
        LotRepository $lotRepository
    ): Response
    {
        $lots = $lotRepository->findBy([], ['price' => "ASC"]);


        return $this->render('admin/admin_lots/admin_lots.html.twig', [
            'lots' => $lots,
        ]);
    }

    #[Route('/new', name: 'new')]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response
    {
        $lot = new Lot();
        $formNewLots = $this->createForm(LotType::class, $lot);
        $formNewLots->handleRequest($request);

        if($formNewLots->isSubmitted() && $formNewLots->isValid()) {
            $entityManager->persist($lot);
            $entityManager->flush();
            return $this->redirectToRoute('admin_lots_index');
        }

        return $this->render('admin/admin_lots/new_lots.html.twig', [
            'formNewLots' => $formNewLots,
        ]);
    }

    #[Route('/edit/{lotId}', name: 'edit')]
    public function edit(
        #[MapEntity(mapping: ['lotId' => 'id'])] Lot $lot,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response
    {
        $formNewLots = $this->createForm(LotType::class, $lot);
        $formNewLots->handleRequest($request);

        if($formNewLots->isSubmitted() && $formNewLots->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('admin_lots_index');
        }

        return $this->render('admin/admin_lots/edit_lots.html.twig', [
            'formNewLots' => $formNewLots,
        ]);
    }

    #[Route('/delete/{lotId}', name: 'delete', methods: ['POST'])]
    public function delete(
        #[MapEntity(mapping: ['lotId' => 'id'])] Lot $lot,
        Request $request, 
        EntityManagerInterface $entityManager
    ): Response
    {
        if ($this->isCsrfTokenValid((string)('delete'.$lot->getId()), $request->request->get('_token'))) {
            $entityManager->remove($lot);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_lots_index', [], Response::HTTP_SEE_OTHER);
    }
}
