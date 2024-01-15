<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    #[Route('/pacman', name: 'jeux-pacman')]
    public function index(): Response
    {
         return $this->render('pacman.html.twig');
    }
    #[Route('/space_invender', name: 'space_invender')]
    public function invender(): Response
    {
         return $this->render('space_invender.html.twig');
    }
}
