<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MentionLegaleController extends AbstractController
{
    #[Route('/mention-legale', name: 'mention_legale')]
    public function index(): Response
    {
        return $this->render('/mention_legale.html.twig');
    }
}
